import { Navbar } from '@/components/app/navbar';
import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { Separator } from '@/components/ui/separator';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import type { RunResource } from '@/types/runs';
import { motion } from 'framer-motion';

interface ShowPageProps {
  run: RunResource;
}

export default function ShowPage({ run }: ShowPageProps) {
  const { slideUpInVariants } = useAnimationVariants();

  return (
    <AnimatedContainer className="flex min-h-screen flex-col">
      <Navbar />
      <div className="mx-auto mt-24 flex w-full max-w-7xl flex-col px-4">
        <motion.div
          variants={slideUpInVariants}
          className="flex items-center justify-between"
        >
          <h1 className="text-3xl font-extrabold tracking-tight lg:text-2xl">
            {run.data.project.name}
          </h1>
        </motion.div>
        <Separator className="mt-8" />
        <div
          className="prose max-w-7xl pb-32 pt-8"
          dangerouslySetInnerHTML={{
            __html: run.data.output.markdown as string,
          }}
        />
      </div>
    </AnimatedContainer>
  );
}
