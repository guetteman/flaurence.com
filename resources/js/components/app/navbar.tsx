import { Link } from '@inertiajs/react';

export function Navbar() {
  return (
    <nav className="py-4">
      <div className="mx-auto flex max-w-7xl items-center justify-between">
        <Link href={route('dashboard')} className="font-bold">
          Flaurence
        </Link>
        <div />
      </div>
    </nav>
  );
}
