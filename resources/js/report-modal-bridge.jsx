import React, { useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import ReportModal from './Components/ReportModal';

// Simple state management
let setModalOpen = null;

// Define function immediately
window.openReportModal = function() {
    if (setModalOpen) {
        setModalOpen(true);
    } else {
        // If React not ready, dispatch event
        window.dispatchEvent(new CustomEvent('open-report-modal'));
    }
};

function BridgeContainer() {
    const [isOpen, setIsOpen] = useState(false);
    const [kategori, setKategori] = useState([]);

    useEffect(() => {
        // Set the function
        setModalOpen = setIsOpen;
        
        // Load kategori
        if (window.reportModalData?.kategori) {
            setKategori(window.reportModalData.kategori);
        }

        // Listen for events
        const handleOpen = () => setIsOpen(true);
        window.addEventListener('open-report-modal', handleOpen);
        
        // Override window function
        window.openReportModal = () => setIsOpen(true);

        return () => {
            window.removeEventListener('open-report-modal', handleOpen);
            setModalOpen = null;
        };
    }, []);

    return (
        <ReportModal 
            isOpen={isOpen} 
            onClose={() => setIsOpen(false)} 
            kategori={kategori} 
        />
    );
}

// Mount React component - wrapped in IIFE to avoid top-level document access
(function() {
    if (typeof document === 'undefined') return;
    
    const init = () => {
        const rootElement = document.getElementById('react-report-modal');
        if (rootElement) {
            const root = createRoot(rootElement);
            root.render(<BridgeContainer />);
        } else {
            setTimeout(init, 100);
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
