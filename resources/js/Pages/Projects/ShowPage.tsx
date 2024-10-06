import { Navbar } from '@/components/app/navbar';
import { RunListItem } from '@/components/app/pages/projects/run-list-item';
import { PlayIcon } from '@/components/icons/play-icon';
import { Button } from '@/components/ui/button';
import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { Separator } from '@/components/ui/separator';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import type { ProjectResource } from '@/types/projects';
import type { RunResourceCollection } from '@/types/runs';
import { router } from '@inertiajs/react';
import { motion } from 'framer-motion';

interface ShowPageProps {
  project: ProjectResource;
  runs: RunResourceCollection;
}

export default function ShowPage({ project, runs }: ShowPageProps) {
  const { slideUpInVariants } = useAnimationVariants();

  function run() {
    router.post(route('runs.store', { project: project.data.id }));
  }

  return (
    <AnimatedContainer className="flex min-h-screen flex-col">
      <Navbar />
      <div className="mx-auto mt-24 flex w-full max-w-7xl flex-col px-4">
        <motion.div
          variants={slideUpInVariants}
          className="flex items-center justify-between"
        >
          <h1 className="text-3xl font-extrabold tracking-tight lg:text-2xl">
            {project.data.name}
          </h1>
          <Button onClick={run}>
            <PlayIcon className="mr-2 size-4" />
            Run
          </Button>
        </motion.div>
        <Separator className="mt-8" />
        <motion.div variants={slideUpInVariants} className="pb-32 pt-8">
          {runs.data.length > 0 &&
            runs.data.map((run) => <RunListItem run={run} key={run.id} />)}
        </motion.div>
      </div>
    </AnimatedContainer>
  );
}
