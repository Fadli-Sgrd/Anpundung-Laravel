import os
import sys
import time
import tempfile
import traceback
from dataclasses import dataclass
from pathlib import Path
from typing import Callable, Optional
from urllib.parse import quote

from selenium import webdriver
from selenium.common.exceptions import TimeoutException
from selenium.common.exceptions import StaleElementReferenceException
from selenium.webdriver import ActionChains
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select, WebDriverWait


BASE_URL = os.getenv("BASE_URL", "http://127.0.0.1:8000").rstrip("/")
BROWSER = os.getenv("BROWSER", "chrome").lower()
HEADLESS = os.getenv("HEADLESS", "0") == "1"
TIMEOUT = int(os.getenv("SELENIUM_TIMEOUT", "12"))
SLOWMO = float(os.getenv("SLOWMO", "0"))
PAUSE_ON_FAIL = os.getenv("PAUSE_ON_FAIL", "0") == "1"
CASE_FILTER = os.getenv("CASES", "").strip()

ADMIN_EMAIL = os.getenv("ADMIN_EMAIL", "admin@email.com")
USER_EMAIL = os.getenv("USER_EMAIL", "user@email.com")
PASSWORD = os.getenv("TEST_PASSWORD", "password")


@dataclass
class CaseResult:
    case_id: str
    name: str
    status: str
    error: str = ""


class SkipCase(Exception):
    pass


class BlackboxSelenium:
    def __init__(self) -> None:
        self.driver = self._make_driver()
        self.wait = WebDriverWait(self.driver, TIMEOUT)
        self.results: list[CaseResult] = []
        self.tmpdir = tempfile.TemporaryDirectory(prefix="anpundung_selenium_")
        self.created_news_titles: list[str] = []
        self.created_report_titles: list[str] = []
        self.runtime_user_email = USER_EMAIL
        self.runtime_user_password = PASSWORD
        self.created_runtime_user = False

    def _make_driver(self):
        if BROWSER == "firefox":
            options = webdriver.FirefoxOptions()
            if HEADLESS:
                options.add_argument("-headless")
            return webdriver.Firefox(options=options)

        options = webdriver.ChromeOptions()
        if HEADLESS:
            options.add_argument("--headless=new")
        options.add_argument("--window-size=1440,1000")
        options.add_argument("--disable-gpu")
        return webdriver.Chrome(options=options)

    def close(self) -> None:
        try:
            self.driver.quit()
        finally:
            self.tmpdir.cleanup()

    def url(self, path: str) -> str:
        if not path.startswith("/"):
            path = "/" + path
        return BASE_URL + path

    def open(self, path: str) -> None:
        self.driver.get(self.url(path))
        self.wait_for_ready()

    def wait_for_ready(self) -> None:
        self.wait.until(lambda d: d.execute_script("return document.readyState") == "complete")
        if SLOWMO:
            time.sleep(SLOWMO)

    def visible(self, by: By, selector: str):
        return self.wait.until(EC.visibility_of_element_located((by, selector)))

    def present(self, by: By, selector: str):
        return self.wait.until(EC.presence_of_element_located((by, selector)))

    def click(self, by: By, selector: str):
        element = self.wait.until(EC.element_to_be_clickable((by, selector)))
        self.driver.execute_script("arguments[0].scrollIntoView({block:'center'});", element)
        element.click()
        return element

    def click_text(self, text: str):
        xpath = (
            "//*[self::button or self::a]"
            f"[contains(normalize-space(.), {self.xpath_literal(text)})]"
        )
        return self.click(By.XPATH, xpath)

    def text_present(self, text: str, timeout: Optional[int] = None) -> bool:
        wait = self.wait if timeout is None else WebDriverWait(self.driver, timeout)
        try:
            wait.until(lambda d: text.lower() in d.find_element(By.TAG_NAME, "body").text.lower())
            return True
        except TimeoutException:
            return False

    def assert_text(self, text: str) -> None:
        if not self.text_present(text):
            body = self.body_text()[:1200]
            raise AssertionError(f"Teks tidak ditemukan: {text!r}\nBody awal:\n{body}")

    def body_text(self) -> str:
        for _ in range(3):
            try:
                return self.driver.find_element(By.TAG_NAME, "body").text
            except StaleElementReferenceException:
                time.sleep(0.2)
        return ""

    def assert_url_contains(self, fragment: str) -> None:
        self.wait.until(lambda d: fragment in d.current_url)

    @staticmethod
    def xpath_literal(value: str) -> str:
        if "'" not in value:
            return f"'{value}'"
        if '"' not in value:
            return f'"{value}"'
        return "concat(" + ", \"'\", ".join(f"'{part}'" for part in value.split("'")) + ")"

    def first_invalid(self):
        return self.driver.execute_script(
            "return document.querySelector('input:invalid, textarea:invalid, select:invalid')"
        )

    def assert_html5_invalid(self) -> None:
        invalid = self.first_invalid()
        if invalid is None:
            raise AssertionError("Tidak ada field HTML5 invalid.")
        message = self.driver.execute_script("return arguments[0].validationMessage", invalid)
        if not message:
            raise AssertionError("Field invalid ditemukan, tapi validationMessage kosong.")

    def clear_and_type(self, element, value: str) -> None:
        element.click()
        element.send_keys(Keys.CONTROL, "a")
        element.send_keys(Keys.BACKSPACE)
        element.send_keys(value)

    def set_input_value(self, element, value: str) -> None:
        self.driver.execute_script(
            """
            const el = arguments[0];
            const value = arguments[1];
            const proto = el.tagName === 'TEXTAREA'
                ? window.HTMLTextAreaElement.prototype
                : window.HTMLInputElement.prototype;
            const setter = Object.getOwnPropertyDescriptor(proto, 'value').set;
            setter.call(el, value);
            el.dispatchEvent(new Event('input', { bubbles: true }));
            el.dispatchEvent(new Event('change', { bubbles: true }));
            """,
            element,
            value,
        )

    def logout_browser(self) -> None:
        self.driver.delete_all_cookies()

    def login(self, email: str, password: str = PASSWORD, expected_path: str = "/home") -> None:
        self.logout_browser()
        self.open("/login")
        actual_email = self.runtime_user_email if email == USER_EMAIL else email
        actual_password = self.runtime_user_password if email == USER_EMAIL else password
        self.visible(By.NAME, "email").send_keys(actual_email)
        self.visible(By.NAME, "password").send_keys(actual_password)
        self.click_text("Masuk")
        try:
            self.wait.until(lambda d: expected_path in d.current_url)
        except TimeoutException:
            if email == USER_EMAIL and actual_email == USER_EMAIL and not self.created_runtime_user:
                self.register_runtime_laporan_user(expected_path=expected_path)
                return
            raise

    def register_runtime_laporan_user(self, expected_path: str = "/home") -> None:
        self.runtime_user_email = f"selenium_laporan_user_{int(time.time())}@example.com"
        self.runtime_user_password = "password123"
        self.created_runtime_user = True

        self.logout_browser()
        self.open("/register")
        self.visible(By.NAME, "name").send_keys("Selenium Laporan User")
        self.visible(By.NAME, "email").send_keys(self.runtime_user_email)
        self.visible(By.NAME, "password").send_keys(self.runtime_user_password)
        self.visible(By.NAME, "password_confirmation").send_keys(self.runtime_user_password)
        self.click_text("Buat Akun Baru")
        self.wait.until(lambda d: expected_path in d.current_url)

    def run_case(self, case_id: str, name: str, func: Callable[[], None]) -> None:
        try:
            func()
            self.results.append(CaseResult(case_id, name, "PASS"))
            print(f"PASS {case_id} - {name}", flush=True)
        except SkipCase as exc:
            self.results.append(CaseResult(case_id, name, "SKIP", str(exc)))
            print(f"SKIP {case_id} - {name}", flush=True)
            print(f"     {exc}", flush=True)
        except Exception as exc:
            details = self.failure_details(exc)
            self.results.append(CaseResult(case_id, name, "FAIL", details))
            print(f"FAIL {case_id} - {name}", flush=True)
            print(f"     {details}", flush=True)
            if os.getenv("SELENIUM_DEBUG", "0") == "1":
                traceback.print_exc()
            if PAUSE_ON_FAIL:
                input("Browser dipause di posisi fail. Tekan Enter untuk lanjut...")

    def failure_details(self, exc: Exception) -> str:
        url = ""
        body = ""
        try:
            url = self.driver.current_url
            body = self.body_text()[:700].replace("\n", " | ")
        except Exception:
            pass
        base = str(exc) or exc.__class__.__name__
        return self.ascii_safe(f"{base}\nURL: {url}\nBody: {body}")

    @staticmethod
    def ascii_safe(value: str) -> str:
        return value.encode("ascii", "replace").decode("ascii")

    def browser_fetch(self, path: str, method: str = "GET", data: Optional[dict] = None) -> dict:
        script = """
            const [url, method, data, done] = arguments;
            const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const form = new FormData();
            if (data) {
                Object.entries(data).forEach(([key, value]) => form.append(key, value));
            }
            fetch(url, {
                method,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: method === 'GET' ? undefined : form,
            })
            .then(async response => done({
                status: response.status,
                url: response.url,
                text: await response.text(),
            }))
            .catch(error => done({status: 0, url, text: String(error)}));
        """
        return self.driver.execute_async_script(script, self.url(path), method, data or {})

    def temp_file(self, name: str, content: bytes) -> str:
        path = Path(self.tmpdir.name) / name
        path.write_bytes(content)
        return str(path)

    def tiny_jpg(self, name: str = "small.jpg") -> str:
        jpg = bytes.fromhex(
            "ffd8ffe000104a46494600010101006000600000ffdb004300"
            "0302020302020303030304030304050805050404050a07070608"
            "0c0a0c0c0b0a0b0b0d0e12100d0e110e0b0b10161011131415"
            "15150c0f171816141812141514ffdb0043010304040504050905"
            "0509120c0a0c1212121212121212121212121212121212121212"
            "1212121212121212121212121212121212121212121212121212"
            "121212121212121212ffc0001108000100010301220002110103"
            "1101ffc400140001000000000000000000000000000000000000"
            "0008ffc400141001000000000000000000000000000000000000"
            "0000ffda000c03010002110311003f00b2c001ffd9"
        )
        return self.temp_file(name, jpg)

    def large_jpg(self) -> str:
        small = Path(self.tiny_jpg("large_2049kb.jpg")).read_bytes()
        payload = small + (b"0" * (2049 * 1024))
        return self.temp_file("large_2049kb.jpg", payload)

    def pdf_file(self) -> str:
        return self.temp_file("dokumen.pdf", b"%PDF-1.4\n1 0 obj\n<<>>\nendobj\n%%EOF\n")

    def select_first_category(self, select_element) -> None:
        select = Select(select_element)
        for option in select.options:
            value = option.get_attribute("value")
            if value:
                select.select_by_value(value)
                return
        raise AssertionError("Kategori tidak tersedia. Jalankan seeder kategori dulu.")

    def ensure_category_exists(self) -> None:
        self.browser_fetch(
            "/kategoris",
            "POST",
            {
                "nama_kategori": "Selenium Kategori",
                "deskripsi": "Kategori otomatis untuk test Selenium",
            },
        )

    def first_category_value_from_modal(self) -> str:
        modal = self.modal_panel()
        select_element = modal.find_element(By.TAG_NAME, "select")
        select = Select(select_element)
        for option in select.options:
            value = option.get_attribute("value")
            if value:
                return value
        raise AssertionError("Kategori tidak tersedia di modal laporan.")

    def modal_panel(self):
        return self.visible(By.CSS_SELECTOR, "div.fixed.inset-0 div.relative.z-10")

    def fill_report_modal(self, title: str, date: str, address: str, description: str) -> None:
        modal = self.modal_panel()
        inputs = modal.find_elements(By.CSS_SELECTOR, "input[type='text']")
        date_input = modal.find_element(By.CSS_SELECTOR, "input[type='date']")
        select = modal.find_element(By.TAG_NAME, "select")
        textarea = modal.find_element(By.TAG_NAME, "textarea")
        self.clear_and_type(inputs[0], title)
        self.set_input_value(date_input, date)
        self.select_first_category(select)
        self.clear_and_type(inputs[-1], address)
        self.clear_and_type(textarea, description)

    def create_report(self, title: str) -> None:
        self.open("/laporan")
        self.ensure_category_exists()
        self.open("/laporan")
        self.click_text("Buat Laporan Baru")
        self.fill_report_modal(title, "2026-06-08", "Jl. Merdeka", "Jalan berlubang")
        self.click_text("Kirim Laporan")
        self.wait.until(lambda d: title in d.find_element(By.TAG_NAME, "body").text)
        self.created_report_titles.append(title)

    def row_by_text(self, text: str):
        literal = self.xpath_literal(text)
        xpath = (
            f"//tr[contains(normalize-space(.), {literal})]"
            f" | //div[contains(@class, 'group') and contains(@class, 'bg-white') and contains(normalize-space(.), {literal})]"
        )
        return self.wait.until(EC.presence_of_element_located((By.XPATH, xpath)))

    def click_row_button_by_title(self, row_text: str, title: str) -> None:
        row_literal = self.xpath_literal(row_text)
        title_literal = self.xpath_literal(title)
        xpath = (
            f"(//*[@title={title_literal} and "
            f"(ancestor::tr[contains(normalize-space(.), {row_literal})] "
            f"or ancestor::div[contains(@class, 'group') and contains(@class, 'bg-white') and contains(normalize-space(.), {row_literal})])])[1]"
        )
        row = self.row_by_text(row_text)
        self.driver.execute_script("arguments[0].scrollIntoView({block:'center'});", row)
        ActionChains(self.driver).move_to_element(row).perform()
        button = self.wait.until(EC.presence_of_element_located((By.XPATH, xpath)))
        self.driver.execute_script("arguments[0].click();", button)

    def fill_news_form(
        self,
        title: Optional[str] = None,
        content: Optional[str] = None,
        excerpt: Optional[str] = None,
        image_path: Optional[str] = None,
        publish: Optional[bool] = None,
        published_at: Optional[str] = None,
    ) -> None:
        form = self.news_form()
        text_input = form.find_element(By.CSS_SELECTOR, "input[type='text']")
        textareas = form.find_elements(By.TAG_NAME, "textarea")
        file_input = form.find_element(By.CSS_SELECTOR, "input[type='file']")
        datetime_input = form.find_element(By.CSS_SELECTOR, "input[type='datetime-local']")
        checkbox = form.find_element(By.CSS_SELECTOR, "input[type='checkbox']")

        if title is not None:
            self.clear_and_type(text_input, title)
        if excerpt is not None:
            self.clear_and_type(textareas[0], excerpt)
        if content is not None:
            self.clear_and_type(textareas[1], content)
        if image_path is not None:
            file_input.send_keys(image_path)
        if published_at is not None:
            self.clear_and_type(datetime_input, published_at)
        if publish is not None and checkbox.is_selected() != publish:
            checkbox.click()

    def news_form(self):
        self.wait.until(lambda d: len(d.find_elements(By.CSS_SELECTOR, "form textarea")) > 0)
        forms = self.driver.find_elements(By.TAG_NAME, "form")
        for form in forms:
            if (
                form.find_elements(By.CSS_SELECTOR, "input[type='text']")
                and len(form.find_elements(By.TAG_NAME, "textarea")) >= 2
                and form.find_elements(By.CSS_SELECTOR, "input[type='file']")
            ):
                return form
        raise AssertionError("Form berita tidak ditemukan. Kemungkinan halaman create/edit belum selesai render.")

    def create_news(self, title: str, with_image: bool = False, publish: bool = False) -> None:
        self.open("/admin/berita/create")
        image = self.tiny_jpg(f"{title}.jpg") if with_image else None
        self.fill_news_form(
            title=title,
            excerpt="Ringkasan selenium",
            content="Isi berita dari selenium",
            image_path=image,
            publish=publish,
        )
        self.click_text("Simpan Berita")
        self.assert_url_contains("/admin/berita")
        self.assert_text(title)
        self.created_news_titles.append(title)

    def delete_news_by_title(self, title: str) -> None:
        self.open(f"/admin/berita?search={quote(title)}")
        self.click_row_button_by_title(title, "Hapus Berita")
        self.driver.switch_to.alert.accept()
        self.wait.until(lambda d: title not in d.find_element(By.TAG_NAME, "body").text)

    def cleanup(self) -> None:
        try:
            self.login(ADMIN_EMAIL, expected_path="/dashboard")
            for title in list(self.created_news_titles):
                try:
                    self.delete_news_by_title(title)
                except Exception:
                    pass
        except Exception:
            pass

        try:
            self.login(USER_EMAIL, expected_path="/home")
            self.open("/laporan")
            for title in list(self.created_report_titles):
                try:
                    self.click_row_button_by_title(title, "Hapus Laporan")
                    self.driver.switch_to.alert.accept()
                except Exception:
                    pass
        except Exception:
            pass

    # Login
    def tc_log_01_empty_fields(self) -> None:
        self.logout_browser()
        self.open("/login")
        self.click_text("Masuk")
        self.assert_html5_invalid()

    def tc_log_02_bad_email_format(self) -> None:
        self.logout_browser()
        self.open("/login")
        self.visible(By.NAME, "email").send_keys("adminexample.com")
        self.visible(By.NAME, "password").send_keys("password123")
        self.click_text("Masuk")
        self.assert_html5_invalid()

    def tc_log_03_wrong_password(self) -> None:
        self.logout_browser()
        self.open("/login")
        self.visible(By.NAME, "email").send_keys(ADMIN_EMAIL)
        self.visible(By.NAME, "password").send_keys("salah123")
        self.click_text("Masuk")
        self.assert_text("Email atau password salah")

    def tc_log_04_unknown_email(self) -> None:
        self.logout_browser()
        self.open("/login")
        self.visible(By.NAME, "email").send_keys("tidakada@example.com")
        self.visible(By.NAME, "password").send_keys("password123")
        self.click_text("Masuk")
        self.assert_text("Email atau password salah")

    def tc_log_05_valid_admin_login(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        self.assert_text("Dashboard")

    # Register
    def tc_reg_01_empty_name(self) -> None:
        self.logout_browser()
        self.open("/register")
        self.visible(By.NAME, "email").send_keys("userbaru@example.com")
        self.visible(By.NAME, "password").send_keys("password123")
        self.visible(By.NAME, "password_confirmation").send_keys("password123")
        self.click_text("Buat Akun Baru")
        self.assert_html5_invalid()

    def tc_reg_02_name_over_255(self) -> None:
        self.logout_browser()
        self.open("/register")
        self.visible(By.NAME, "name").send_keys("A" * 256)
        self.visible(By.NAME, "email").send_keys(f"longname{int(time.time())}@example.com")
        self.visible(By.NAME, "password").send_keys("password123")
        self.visible(By.NAME, "password_confirmation").send_keys("password123")
        self.click_text("Buat Akun Baru")
        self.assert_text("characters")

    def tc_reg_03_bad_email_format(self) -> None:
        self.logout_browser()
        self.open("/register")
        self.visible(By.NAME, "name").send_keys("Fadli")
        self.visible(By.NAME, "email").send_keys("fadlimail.com")
        self.visible(By.NAME, "password").send_keys("password123")
        self.visible(By.NAME, "password_confirmation").send_keys("password123")
        self.click_text("Buat Akun Baru")
        self.assert_html5_invalid()

    def tc_reg_04_duplicate_email(self) -> None:
        self.logout_browser()
        self.open("/register")
        self.visible(By.NAME, "name").send_keys("Fadli")
        self.visible(By.NAME, "email").send_keys(ADMIN_EMAIL)
        self.visible(By.NAME, "password").send_keys("password123")
        self.visible(By.NAME, "password_confirmation").send_keys("password123")
        self.click_text("Buat Akun Baru")
        self.assert_text("already been taken")

    def tc_reg_05_password_too_short_actual_code_min_6(self) -> None:
        self.logout_browser()
        self.open("/register")
        self.visible(By.NAME, "name").send_keys("Fadli")
        self.visible(By.NAME, "email").send_keys(f"shortpass{int(time.time())}@example.com")
        self.visible(By.NAME, "password").send_keys("pass1")
        self.visible(By.NAME, "password_confirmation").send_keys("pass1")
        self.click_text("Buat Akun Baru")
        self.assert_text("at least 6")

    def tc_reg_06_valid_register(self) -> None:
        self.logout_browser()
        self.open("/register")
        email = f"selenium_user_{int(time.time())}@example.com"
        self.visible(By.NAME, "name").send_keys("Fadli Selenium")
        self.visible(By.NAME, "email").send_keys(email)
        self.visible(By.NAME, "password").send_keys("password123")
        self.visible(By.NAME, "password_confirmation").send_keys("password123")
        self.click_text("Buat Akun Baru")
        self.assert_url_contains("/home")
        self.assert_text("Laporkan")

    # Laporan
    def tc_lap_01_empty_fields(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        self.open("/laporan")
        self.click_text("Buat Laporan Baru")
        self.click_text("Kirim Laporan")
        self.assert_html5_invalid()

    def tc_lap_02_title_over_255(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        self.open("/laporan")
        self.ensure_category_exists()
        self.open("/laporan")
        self.click_text("Buat Laporan Baru")
        self.fill_report_modal("A" * 256, "2026-06-08", "Jl. Merdeka", "Jalan berlubang")
        self.click_text("Kirim Laporan")
        self.assert_text("255")

    def tc_lap_03_invalid_date(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        self.open("/laporan")
        self.ensure_category_exists()
        self.open("/laporan")
        self.click_text("Buat Laporan Baru")
        category_id = self.first_category_value_from_modal()
        response = self.browser_fetch(
            "/laporan",
            "POST",
            {
                "judul": "Tanggal Salah Selenium",
                "tanggal": "2026-99-99",
                "alamat": "Jl. Merdeka",
                "deskripsi": "Tanggal invalid",
                "id_kategori": category_id,
            },
        )
        if response["status"] != 422:
            raise AssertionError(f"Expected 422, got {response['status']}: {response['text'][:300]}")

    def tc_lap_04_valid_create_pending(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        title = f"Jalan Rusak Selenium {int(time.time())}"
        self.create_report(title)
        self.assert_text("Pending")

    def tc_lap_05_server_error_note(self) -> None:
        raise SkipCase("Tidak dieksekusi otomatis: butuh database/server sengaja dibuat error.")

    def tc_lap_06_view_valid_detail(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        title = f"Detail Laporan Selenium {int(time.time())}"
        self.create_report(title)
        self.click_row_button_by_title(title, "Lihat Detail")
        self.assert_text("Status Laporan")
        self.assert_text(title)

    def tc_lap_07_view_not_found(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        self.open("/laporan")
        self.assert_text("Riwayat Laporan")
        # Aplikasi tidak menyediakan route GET detail by kode; detail hanya modal dari data list.
        # Kasus not found untuk controller diuji lewat update/delete invalid di bawah.

    def tc_lap_08_update_not_found(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        self.open("/laporan")
        response = self.browser_fetch(
            "/laporan/LAP-999",
            "POST",
            {
                "_method": "PUT",
                "judul": "Update",
                "tanggal": "2026-06-08",
                "alamat": "Jl. Baru",
                "deskripsi": "Update",
                "id_kategori": "1",
            },
        )
        if response["status"] != 404:
            raise AssertionError(f"Expected 404, got {response['status']}")

    def tc_lap_09_update_non_pending(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        title = f"Non Pending Selenium {int(time.time())}"
        self.create_report(title)
        self.logout_browser()
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        self.open("/laporan")
        row = self.row_by_text(title)
        status_button = row.find_element(By.XPATH, ".//button[contains(normalize-space(.), 'Pending')]")
        self.driver.execute_script("arguments[0].click();", status_button)
        self.click_text("Proses")
        self.wait.until(lambda d: "Proses" in self.row_by_text(title).text)
        self.logout_browser()
        self.login(USER_EMAIL, expected_path="/home")
        self.open("/laporan")
        row = self.row_by_text(title)
        if row.find_elements(By.XPATH, ".//*[@title='Edit Laporan']"):
            raise AssertionError("Tombol edit masih muncul untuk laporan non-Pending.")

    def tc_lap_10_update_invalid_data(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        title = f"Invalid Update Selenium {int(time.time())}"
        self.create_report(title)
        self.click_row_button_by_title(title, "Edit Laporan")
        modal = self.modal_panel()
        for element in modal.find_elements(By.CSS_SELECTOR, "input[type='text'], textarea"):
            self.clear_and_type(element, "")
        self.click_text("Simpan Perubahan")
        self.assert_html5_invalid()

    def tc_lap_11_update_valid(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        title = f"Update Laporan Selenium {int(time.time())}"
        new_title = f"Update Jalan Rusak Selenium {int(time.time())}"
        self.create_report(title)
        self.click_row_button_by_title(title, "Edit Laporan")
        self.fill_report_modal(new_title, "2026-06-08", "Jl. Baru", "Lubang semakin besar")
        self.click_text("Simpan Perubahan")
        self.wait.until(lambda d: new_title in d.find_element(By.TAG_NAME, "body").text)
        self.created_report_titles.append(new_title)

    def tc_lap_12_delete_valid(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        title = f"Delete Laporan Selenium {int(time.time())}"
        self.create_report(title)
        self.click_row_button_by_title(title, "Hapus Laporan")
        self.driver.switch_to.alert.accept()
        self.wait.until(lambda d: title not in d.find_element(By.TAG_NAME, "body").text)

    def tc_lap_13_delete_not_found(self) -> None:
        self.login(USER_EMAIL, expected_path="/home")
        self.open("/laporan")
        response = self.browser_fetch("/laporan/LAP-999", "POST", {"_method": "DELETE"})
        if response["status"] != 404:
            raise AssertionError(f"Expected 404, got {response['status']}")

    # Berita
    def tc_brt_01_list_without_search(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        self.open("/admin/berita")
        self.assert_text("Kelola Berita")

    def tc_brt_02_search_keyword(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        self.open("/admin/berita")
        search = self.visible(By.CSS_SELECTOR, "input[placeholder='Cari berita...']")
        self.clear_and_type(search, "pungli")
        search.send_keys(Keys.ENTER)
        self.wait.until(lambda d: "search=pungli" in d.current_url or "pungli" in d.find_element(By.TAG_NAME, "body").text.lower())
        self.assert_text("pungli")

    def tc_brt_03_create_required_empty(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        self.open("/admin/berita/create")
        self.click_text("Simpan Berita")
        self.assert_text("required")

    def tc_brt_04_title_over_255(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        self.open("/admin/berita/create")
        self.fill_news_form(title="A" * 256, content="Isi berita")
        self.click_text("Simpan Berita")
        self.assert_text("255")

    def tc_brt_05_file_not_image(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        self.open("/admin/berita/create")
        self.fill_news_form(
            title=f"File PDF Selenium {int(time.time())}",
            content="Isi berita",
            image_path=self.pdf_file(),
        )
        self.click_text("Simpan Berita")
        self.assert_text("image")

    def tc_brt_06_image_over_2048kb(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        self.open("/admin/berita/create")
        self.fill_news_form(
            title=f"Image Besar Selenium {int(time.time())}",
            content="Isi berita",
            image_path=self.large_jpg(),
        )
        self.click_text("Simpan Berita")
        self.assert_text("2048")

    def tc_brt_07_publish_without_date(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        title = f"Berita Publish Selenium {int(time.time())}"
        self.create_news(title, with_image=False, publish=True)
        self.assert_text("Published")

    def tc_brt_08_create_valid_without_image(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        title = f"Berita Baru Selenium {int(time.time())}"
        self.create_news(title, with_image=False, publish=False)

    def tc_brt_09_edit_not_found(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        self.open("/admin/berita/9999/edit")
        if "404" not in self.driver.title and "not found" not in self.driver.find_element(By.TAG_NAME, "body").text.lower():
            raise AssertionError("Halaman edit ID 9999 tidak menampilkan 404/not found.")

    def tc_brt_10_edit_invalid_data(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        title = f"Edit Invalid Selenium {int(time.time())}"
        self.create_news(title)
        self.click_row_button_by_title(title, "Edit Berita")
        self.fill_news_form(title="", content="")
        self.click_text("Update Berita")
        self.assert_text("required")

    def tc_brt_11_update_with_new_image_old_image_exists(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        title = f"Old Image Selenium {int(time.time())}"
        updated = f"Old Image Updated Selenium {int(time.time())}"
        self.create_news(title, with_image=True)
        self.click_row_button_by_title(title, "Edit Berita")
        self.fill_news_form(title=updated, content="Isi update", image_path=self.tiny_jpg("baru.jpg"))
        self.click_text("Update Berita")
        self.assert_url_contains("/admin/berita")
        self.assert_text(updated)
        self.created_news_titles.append(updated)

    def tc_brt_12_update_with_new_image_no_old_image(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        title = f"No Image Selenium {int(time.time())}"
        updated = f"No Image Updated Selenium {int(time.time())}"
        self.create_news(title, with_image=False)
        self.click_row_button_by_title(title, "Edit Berita")
        self.fill_news_form(title=updated, content="Isi update", image_path=self.tiny_jpg("baru-no-old.jpg"))
        self.click_text("Update Berita")
        self.assert_url_contains("/admin/berita")
        self.assert_text(updated)
        self.created_news_titles.append(updated)

    def tc_brt_13_update_without_image_change(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        title = f"No Image Change Selenium {int(time.time())}"
        updated = f"Judul Update Selenium {int(time.time())}"
        self.create_news(title, with_image=True)
        self.click_row_button_by_title(title, "Edit Berita")
        self.fill_news_form(title=updated, content="Isi update")
        self.click_text("Update Berita")
        self.assert_url_contains("/admin/berita")
        self.assert_text(updated)
        self.created_news_titles.append(updated)

    def tc_brt_14_delete_not_found(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        self.open("/admin/berita")
        response = self.browser_fetch("/admin/berita/9999", "POST", {"_method": "DELETE"})
        if response["status"] != 404:
            raise AssertionError(f"Expected 404, got {response['status']}")

    def tc_brt_15_delete_with_image(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        title = f"Delete Image Selenium {int(time.time())}"
        self.create_news(title, with_image=True)
        self.delete_news_by_title(title)

    def tc_brt_16_delete_without_image(self) -> None:
        self.login(ADMIN_EMAIL, expected_path="/dashboard")
        title = f"Delete No Image Selenium {int(time.time())}"
        self.create_news(title, with_image=False)
        self.delete_news_by_title(title)

    def run_all(self) -> int:
        cases = [
            ("TC-LOG-01", "login empty fields", self.tc_log_01_empty_fields),
            ("TC-LOG-02", "login bad email format", self.tc_log_02_bad_email_format),
            ("TC-LOG-03", "login wrong password", self.tc_log_03_wrong_password),
            ("TC-LOG-04", "login unknown email", self.tc_log_04_unknown_email),
            ("TC-LOG-05", "login valid admin", self.tc_log_05_valid_admin_login),
            ("TC-REG-01", "register empty name", self.tc_reg_01_empty_name),
            ("TC-REG-02", "register name over 255", self.tc_reg_02_name_over_255),
            ("TC-REG-03", "register bad email format", self.tc_reg_03_bad_email_format),
            ("TC-REG-04", "register duplicate email", self.tc_reg_04_duplicate_email),
            ("TC-REG-05", "register short password per actual min 6", self.tc_reg_05_password_too_short_actual_code_min_6),
            ("TC-REG-06", "register valid", self.tc_reg_06_valid_register),
            ("TC-LAP-01", "laporan empty fields", self.tc_lap_01_empty_fields),
            ("TC-LAP-02", "laporan title over 255", self.tc_lap_02_title_over_255),
            ("TC-LAP-03", "laporan invalid date", self.tc_lap_03_invalid_date),
            ("TC-LAP-04", "laporan create valid pending", self.tc_lap_04_valid_create_pending),
            ("TC-LAP-05", "laporan server/database error manual", self.tc_lap_05_server_error_note),
            ("TC-LAP-06", "laporan view valid detail", self.tc_lap_06_view_valid_detail),
            ("TC-LAP-07", "laporan view not found route note", self.tc_lap_07_view_not_found),
            ("TC-LAP-08", "laporan update not found", self.tc_lap_08_update_not_found),
            ("TC-LAP-09", "laporan update non pending", self.tc_lap_09_update_non_pending),
            ("TC-LAP-10", "laporan update invalid data", self.tc_lap_10_update_invalid_data),
            ("TC-LAP-11", "laporan update valid", self.tc_lap_11_update_valid),
            ("TC-LAP-12", "laporan delete valid", self.tc_lap_12_delete_valid),
            ("TC-LAP-13", "laporan delete not found", self.tc_lap_13_delete_not_found),
            ("TC-BRT-01", "berita list without search", self.tc_brt_01_list_without_search),
            ("TC-BRT-02", "berita search keyword", self.tc_brt_02_search_keyword),
            ("TC-BRT-03", "berita create empty required", self.tc_brt_03_create_required_empty),
            ("TC-BRT-04", "berita title over 255", self.tc_brt_04_title_over_255),
            ("TC-BRT-05", "berita upload non image", self.tc_brt_05_file_not_image),
            ("TC-BRT-06", "berita image over 2048kb", self.tc_brt_06_image_over_2048kb),
            ("TC-BRT-07", "berita publish without date", self.tc_brt_07_publish_without_date),
            ("TC-BRT-08", "berita create valid without image", self.tc_brt_08_create_valid_without_image),
            ("TC-BRT-09", "berita edit not found", self.tc_brt_09_edit_not_found),
            ("TC-BRT-10", "berita edit invalid data", self.tc_brt_10_edit_invalid_data),
            ("TC-BRT-11", "berita update image old exists", self.tc_brt_11_update_with_new_image_old_image_exists),
            ("TC-BRT-12", "berita update image no old image", self.tc_brt_12_update_with_new_image_no_old_image),
            ("TC-BRT-13", "berita update without image change", self.tc_brt_13_update_without_image_change),
            ("TC-BRT-14", "berita delete not found", self.tc_brt_14_delete_not_found),
            ("TC-BRT-15", "berita delete with image", self.tc_brt_15_delete_with_image),
            ("TC-BRT-16", "berita delete without image", self.tc_brt_16_delete_without_image),
        ]

        for case_id, name, func in cases:
            if CASE_FILTER:
                allowed = {item.strip().upper() for item in CASE_FILTER.split(",") if item.strip()}
                token = case_id.upper()
                group = case_id.split("-")[1].upper() if "-" in case_id else token
                if token not in allowed and group not in allowed:
                    continue
            self.run_case(case_id, name, func)

        print("\nSummary")
        print("=======")
        passed = sum(1 for result in self.results if result.status == "PASS")
        skipped = sum(1 for result in self.results if result.status == "SKIP")
        failed = sum(1 for result in self.results if result.status == "FAIL")
        print(f"Passed: {passed}", flush=True)
        print(f"Skipped: {skipped}", flush=True)
        print(f"Failed: {failed}", flush=True)
        for result in self.results:
            print(f"{result.status} {result.case_id} {result.name}", flush=True)
            if result.error:
                print(f"  {result.error}", flush=True)

        return 0 if failed == 0 else 1


def main() -> int:
    runner = BlackboxSelenium()
    try:
        return runner.run_all()
    finally:
        runner.cleanup()
        runner.close()


if __name__ == "__main__":
    sys.exit(main())
