import { Navbar } from '@/components/app/navbar';
import { Settings02Icon } from '@/components/icons/settings-02-icon';
import { Button } from '@/components/ui/button';
import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { Separator } from '@/components/ui/separator';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import type { ProjectResource } from '@/types/projects';
import { motion } from 'framer-motion';

interface ShowPageProps {
  project: ProjectResource;
}

export default function ShowPage({ project }: ShowPageProps) {
  const { slideUpInVariants } = useAnimationVariants();

  return (
    <AnimatedContainer className="flex min-h-screen flex-col gap-32">
      <Navbar />
      <div className="mx-auto mt-24 flex w-full max-w-7xl flex-col px-4">
        <motion.div
          variants={slideUpInVariants}
          className="flex items-center justify-between"
        >
          <h1 className="text-3xl font-extrabold tracking-tight lg:text-2xl">
            {project.data.name}
          </h1>
          <Button>
            <Settings02Icon className="mr-2 size-4" />
            Settings
          </Button>
        </motion.div>
        <Separator className="mt-8" />
      </div>
    </AnimatedContainer>
  );
}
