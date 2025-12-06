import React from 'react';
import { Link } from '@inertiajs/react';

export default function Layout({ children }) {
  return (
    <div className="min-h-screen bg-gray-50">
      <header className="bg-white shadow">
        <div className="mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
          <div className="text-lg font-semibold">MyWeather</div>
          <nav className="space-x-4">
            <Link href="/" className="text-sm text-gray-700">Home</Link>
            <Link href="/preferences/ui/edit" className="text-sm text-gray-700">Preferences</Link>
          </nav>
        </div>
      </header>
      <main className="mx-auto max-w-5xl p-4">{children}</main>
    </div>
  );
}
