import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { CreditCardPosIcon } from '@/components/icons/credit-card-pos';
import { Logo } from '../logo';
import { Isotype } from '../isotype';

export function Navbar() {
  return (
    <nav className="py-4">
      <div className="mx-auto flex max-w-7xl items-center justify-between px-4">
        <Link
          href={route('dashboard')}
          className="flex items-baseline gap-2 font-bold"
        >
          <Isotype className="h-5" />
          <Logo className="h-4" />
        </Link>
        <div>
          <Button asChild variant="secondary">
            <Link href={route('billing.index')} className="font-bold">
              <CreditCardPosIcon className="mr-2 h-4 w-4" />
              Billing
            </Link>
          </Button>
        </div>
      </div>
    </nav>
  );
}
