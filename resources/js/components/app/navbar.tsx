import { Link, router, usePage } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { CreditCardPosIcon } from '@/components/icons/credit-card-pos';
import { Logo } from '../logo';
import { Isotype } from '../isotype';
import type { UserResource } from '@/types/user';

export function Navbar() {
  const { user } = usePage<{ user: UserResource }>().props;
  function logout() {
    router.post(route('logout'));
  }

  return (
    <nav className="py-4">
      <div className="mx-auto flex max-w-7xl items-center justify-between px-4">
        <Link
          href={user ? route('dashboard') : route('welcome')}
          className="flex items-baseline gap-2 font-bold"
        >
          <Isotype className="h-5" />
          <Logo className="h-4" />
        </Link>
        <div className="flex items-center gap-2">
          {user ? (
            <>
              <Button asChild variant="secondary">
                <Link href={route('billing.index')} className="font-bold">
                  <CreditCardPosIcon className="mr-2 h-4 w-4" />
                  Billing
                </Link>
              </Button>
              <Button variant="link" onClick={logout}>
                Logout
              </Button>
            </>
          ) : (
            <>
              <Button asChild>
                <Link href={route('register')}>Get started</Link>
              </Button>
              <Button variant="link" asChild>
                <Link href={route('login')}>Log in</Link>
              </Button>
            </>
          )}
        </div>
      </div>
    </nav>
  );
}
