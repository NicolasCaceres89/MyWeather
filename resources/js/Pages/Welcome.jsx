import { Head, Link } from '@inertiajs/react';
import React from 'react'; // Importar React explícitamente es buena práctica

export default function Welcome({ auth }) {
    
    // Función de manejo de errores, ya no contiene imports
    const handleImageError = () => {
        document
            .getElementById('screenshot-container')
            ?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        // Se eliminó el código duplicado y los imports incorrectos aquí.
    };

    return (
        <>
            <Head title="Welcome" />
            <div className="min-h-screen bg-gradient-to-br from-background to-muted flex flex-col">
                {/* Header */}
                <header className="border-b border-border">
                    <div className="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            {/* Cloud icon */}
                            <svg className="w-8 h-8 text-primary" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 17.58A4.5 4.5 0 0 0 17.5 9h-.26A6 6 0 0 0 6 10.5C4.34 10.5 3 11.84 3 13.5S4.34 16.5 6 16.5h11a3 3 0 0 0 3-3 3 3 0 0 0-0.1-0.83" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                            </svg>
                            <span className="text-2xl font-bold text-foreground">MyWeather</span>
                        </div>

                        <nav className="hidden md:flex items-center gap-8">
                            {!auth.user ? (
                                <>
                                    <Link href={route('login')} className="text-foreground hover:text-primary transition">Iniciar Sesión</Link>
                                    <Link href={route('register')} className="text-foreground hover:text-primary transition">Registrarse</Link>
                                </>
                            ) : (
                                <Link href={route('dashboard')} className="text-foreground hover:text-primary transition">Dashboard</Link>
                            )}
                        </nav>

                        <button className="md:hidden inline-flex items-center justify-center p-2 rounded-md text-foreground">
                            {/* Menu icon */}
                            <svg className="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                            </svg>
                        </button>
                    </div>
                </header>

                {/* Main Content */}
                <main className="flex-1 flex items-center justify-center px-4">
                    <div className="text-center max-w-2xl">
                        <h1 className="text-5xl md:text-6xl font-bold text-foreground mb-6">Consulta el Clima en Tiempo Real</h1>
                        <p className="text-lg text-muted-foreground mb-12">
                            MyWeather es tu aplicación minimalista para estar siempre al tanto del clima en tus ubicaciones favoritas.
                            Diseño limpio, información clara y acceso rápido.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link href={route('search') || '/search'}>
                                <a className="px-6 py-3 bg-primary text-white rounded-md text-lg">Explorar Clima</a>
                            </Link>
                            <Link href={route('register')}>
                                <a className="px-6 py-3 border border-current rounded-md text-lg">Crear Cuenta</a>
                            </Link>
                        </div>
                    </div>
                </main>

                {/* Footer */}
                <footer className="border-t border-border py-8 px-4">
                    <div className="max-w-7xl mx-auto text-center text-muted-foreground text-sm">
                        <p>&copy; 2025 MyWeather. Todos los derechos reservados.</p>
                    </div>
                </footer>
            </div>
        </>
    );
}
