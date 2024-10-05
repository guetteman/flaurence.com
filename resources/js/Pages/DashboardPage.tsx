import { Navbar } from '@/components/app/navbar';
import { EmptyProjects } from '@/components/app/pages/dashboard/empty-projects';
import { PlusSignIcon } from '@/components/icons/plus-sign-icon';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { Separator } from '@/components/ui/separator';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import type { ProjectResourceCollection } from '@/types/projects';
import { Link } from '@inertiajs/react';
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
        <div className="mt-10">
          {projects.data.length ? (
            <div className="grid grid-cols-1 gap-4 md:grid-cols-3">
              {projects.data.map((project) => (
                <Link
                  key={project.id}
                  href={route('projects.show', project.id)}
                >
                  <Card className="hover:bg-gray-50">
                    <CardHeader>
                      <CardTitle>{project.name}</CardTitle>
                    </CardHeader>
                    <CardContent>
                      <p className="text-sm text-gray-500">
                        {project.flow.name}
                      </p>
                    </CardContent>
                  </Card>
                </Link>
              ))}
            </div>
          ) : (
            <EmptyProjects />
          )}
        </div>
      </div>
    </AnimatedContainer>
  );
}
