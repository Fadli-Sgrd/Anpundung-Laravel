import React, { useState, useEffect, useCallback, useRef } from 'react';
import { router } from '@inertiajs/react';

export default function SearchInput({ routeName, placeholder = "Cari berita...", initialValue = "" }) {
    const [search, setSearch] = useState(initialValue);
    const initialRender = useRef(true);

    // Simple debounce implementation
    const debounce = (func, delay) => {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => func(...args), delay);
        };
    };

    const performSearch = useCallback(
        debounce((query) => {
            router.get(
                route(routeName),
                { search: query },
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                }
            );
        }, 300),
        [routeName]
    );

    useEffect(() => {
        if (initialRender.current) {
            initialRender.current = false;
            return;
        }
        performSearch(search);
    }, [search, performSearch]);

    const handleKeyDown = (e) => {
        if (e.key === 'Enter') {
            router.get(
                route(routeName),
                { search: search },
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                }
            );
        }
    };

    return (
        <div className="relative group w-full max-w-md">
            <input
                type="text"
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                onKeyDown={handleKeyDown}
                placeholder={placeholder}
                className="block w-full px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50/50 transition-all duration-300 font-bold shadow-sm group-hover:shadow-md"
            />
            {search && (
                <button
                    onClick={() => setSearch('')}
                    className="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-300 hover:text-slate-500 transition-colors"
                >
                    <i className="bx bx-x-circle text-2xl"></i>
                </button>
            )}
        </div>
    );
}

