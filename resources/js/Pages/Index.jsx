import { useState, useEffect } from "react";

export default function Index() {
    const [dark, setDark] = useState(false);

    // Añade o quita la clase "dark" al <html>
    useEffect(() => {
        if (dark) {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
    }, [dark]);

    return (
        <div className="min-h-screen bg-background text-foreground flex flex-col items-center justify-center transition-colors duration-300">
            <h1 className="text-4xl font-bold mb-6">
                Modo {dark ? "Oscuro" : "Claro"}
            </h1>

            <button
                onClick={() => setDark(!dark)}
                className="px-6 py-3 rounded-lg bg-primary text-primary-foreground hover:opacity-90 transition"
            >
                Cambiar tema
            </button>

            <p className="mt-6 text-muted-foreground">
                Este es un ejemplo usando Tailwind + variables CSS + darkMode: ['class']
            </p>
        </div>
    );
}
