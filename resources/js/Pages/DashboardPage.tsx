import { Navbar } from '@/components/app/navbar';
import { EmptyProjects } from '@/components/app/pages/dashboard/empty-projects';
import { PlusSignIcon } from '@/components/icons/plus-sign-icon';
import { Button } from '@/components/ui/button';
import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { Separator } from '@/components/ui/separator';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import type { ProjectResourceCollection } from '@/types/projects';
import {Link} from '@inertiajs/react';
import { motion } from 'framer-motion';

interface DashboardPageProps {
  projects: ProjectResourceCollection;
}

export default function DashboardPage({ projects }: DashboardPageProps) {
  const { slideUpInVariants } = useAnimationVariants();
  return (
    <AnimatedContainer className="flex min-h-screen flex-col">
      <Navbar />
      <div className="mx-auto mt-24 flex w-full max-w-7xl flex-col px-4">
        <motion.div
          variants={slideUpInVariants}
          className="flex items-center justify-end"
        >
          <Link href={route('projects.create')}>
            <Button>
              <PlusSignIcon className="mr-2 size-4" />
              New Project
            </Button>
          </Link>
        </motion.div>
        <Separator className="mt-8" />
        <div>
          {projects.data.length ? <div>Projects</div> : <EmptyProjects />}
        </div>
      </div>
    </AnimatedContainer>
  );
}
