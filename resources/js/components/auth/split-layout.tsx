import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import { motion } from 'framer-motion';
import { Scissors } from 'lucide-react';
import type { ReactNode } from 'react';

export function SplitLayout({ children }: { children: ReactNode }) {
  const { slideUpInVariants } = useAnimationVariants();

  return (
    <AnimatedContainer className="flex min-h-screen">
      <div className="hidden w-1/2 bg-black text-white lg:block">
        <div className="flex h-full flex-col justify-between p-8">
          <motion.div
            variants={slideUpInVariants}
            className="flex items-center space-x-2"
          >
            <Scissors className="size-8" />
            <span className="text-xl font-bold">Flaurence</span>
          </motion.div>
          <motion.div variants={slideUpInVariants} className="max-w-2xl">
            <blockquote>
              "This library has saved me countless hours of work and helped me
              deliver stunning designs to my clients faster than ever before."
            </blockquote>
            <cite className="mt-2 block">Sofia Davis</cite>
          </motion.div>
        </div>
      </div>
      <div className="flex w-full items-center justify-center lg:w-1/2">
        {children}
      </div>
    </AnimatedContainer>
  );
}
