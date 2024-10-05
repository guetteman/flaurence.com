import { Navbar } from '@/components/app/navbar';
import { PlayIcon } from '@/components/icons/play-icon';
import { Button } from '@/components/ui/button';
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
          <Button onClick={run}>
            <PlayIcon className="mr-2 size-4" />
            Run
          </Button>
        </motion.div>
        <Separator className="mt-8" />
        <div className="mt-8">
          {runs.data.length > 0 &&
            runs.data.map((run) => (
              <Link
                href={route('runs.show', {
                  project: project.data.id,
                  run: run.id,
                })}
                key={run.id}
                className="flex items-center justify-between"
              >
                <div className="flex items-center space-x-2">
                  <div className="flex h-6 w-6 items-center justify-center rounded-full bg-gray-50">
                    <PlayIcon className="h-4 w-4" />
                  </div>
                  <div className="text-sm font-medium text-gray-900">
                    {run.status}
                  </div>
                </div>
                <div className="text-sm text-gray-500">{run.created_at}</div>
              </Link>
            ))}
        </div>
      </div>
    </AnimatedContainer>
  );
}
