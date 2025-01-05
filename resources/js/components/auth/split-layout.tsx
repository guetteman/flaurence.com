import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { IsotypeDark } from '@/components/isotype-dark';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import { motion } from 'framer-motion';
import type { ReactNode } from 'react';
import { Logo } from '../logo';
import { Link } from '@inertiajs/react';

export function SplitLayout({ children }: { children: ReactNode }) {
  const { slideUpInVariants } = useAnimationVariants();

  return (
    <AnimatedContainer className="flex min-h-screen">
      <div className="hidden w-1/2 bg-black text-white lg:block">
        <div className="flex h-full flex-col justify-between p-8">
          <motion.div variants={slideUpInVariants}>
            <Link href={route('welcome')} className="flex items-baseline gap-2">
              <IsotypeDark className="size-6" />
              <Logo className="h-5" />
            </Link>
          </motion.div>
          <motion.div variants={slideUpInVariants} className="max-w-2xl">
            <blockquote className="text-xl">
              Your curated content, your style, your newsletter.
            </blockquote>
          </motion.div>
        </div>
      </div>
      <div className="flex w-full items-center justify-center lg:w-1/2">
        {children}
      </div>
    </AnimatedContainer>
  );
}
