import { Navbar } from '@/components/app/navbar';
import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { motion } from 'framer-motion';
import { Separator } from '@/components/ui/separator';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import type { PlanResourceCollection } from '@/types/plans';
import { Plans } from '@/components/app/pages/billing/plans';

interface BillingPageProps {
  plans: PlanResourceCollection;
}

export default function BillingPage({ plans }: BillingPageProps) {
  const { slideUpInVariants } = useAnimationVariants();

  return (
    <AnimatedContainer className="flex min-h-screen flex-col">
      <Navbar />
      <div className="mx-auto mt-24 flex w-full max-w-7xl flex-col px-4">
        <motion.div variants={slideUpInVariants} className="flex items-center">
          <h1 className="text-2xl font-bold">Billing</h1>
        </motion.div>
        <Separator className="mt-8" />
        <Plans plans={plans} />
      </div>
    </AnimatedContainer>
  );
}
