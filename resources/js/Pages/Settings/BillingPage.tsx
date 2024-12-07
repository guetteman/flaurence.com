import { Navbar } from '@/components/app/navbar';
import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { motion } from 'framer-motion';
import { Separator } from '@/components/ui/separator';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import type { PlanResourceCollection } from '@/types/plans';
import { Plans } from '@/components/app/pages/billing/plans';
import type { UserResource } from '@/types/user';
import { ActiveSubscription } from '@/components/app/pages/billing/active-subscription';

interface BillingPageProps {
  plans: PlanResourceCollection;
  user: UserResource;
}

export default function BillingPage({ plans, user }: BillingPageProps) {
  const { slideUpInVariants } = useAnimationVariants();

  return (
    <AnimatedContainer className="flex min-h-screen flex-col">
      <Navbar />
      <div className="mx-auto mt-24 flex w-full max-w-7xl flex-col px-4">
        <motion.div variants={slideUpInVariants} className="flex items-center">
          <h1 className="text-2xl font-bold">Billing</h1>
        </motion.div>
        <Separator className="mt-8" />
        {!user.data.subscribed ? (
          <Plans plans={plans} />
        ) : (
          <div className="mx-auto mt-8 w-full max-w-4xl">
            <ActiveSubscription />
          </div>
        )}
      </div>
    </AnimatedContainer>
  );
}
