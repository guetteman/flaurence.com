import { Navbar } from '@/components/app/navbar';
import { RunListItem } from '@/components/app/pages/projects/run-list-item';
import { PlayIcon } from '@/components/icons/play-icon';
import { Settings02Icon } from '@/components/icons/settings-02-icon';
import { Button, buttonVariants } from '@/components/ui/button';
import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { Separator } from '@/components/ui/separator';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import type { ProjectResource } from '@/types/projects';
import type { RunResourceCollection } from '@/types/runs';
import { Link, router } from '@inertiajs/react';
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
          <div className="flex items-center gap-2">
            <Link
              href={route('projects.edit', project.data.id)}
              className={buttonVariants({ variant: 'secondary', size: 'icon' })}
            >
              <Settings02Icon className="size-4" />
            </Link>
            <Button onClick={run}>
              <PlayIcon className="mr-2 size-4" />
              Run
            </Button>
          </div>
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
