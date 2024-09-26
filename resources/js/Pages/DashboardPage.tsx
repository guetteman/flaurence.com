import { Navbar } from '@/components/app/navbar';
import { EmptyProjects } from '@/components/app/pages/dashboard/empty-projects';
import { PlusSignIcon } from '@/components/icons/plus-sign-icon';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import type { ProjectResourceCollection } from '@/types/projects';

interface DashboardPageProps {
  projects: ProjectResourceCollection;
}

export default function DashboardPage({ projects }: DashboardPageProps) {
  return (
    <div className="flex min-h-screen flex-col">
      <Navbar />
      <div className="mx-auto mt-24 flex w-full max-w-7xl flex-col px-4">
        <div className="flex items-center justify-end">
          <Button>
            <PlusSignIcon className="mr-2 size-4" />
            New Project
          </Button>
        </div>
        <Separator className="mt-8" />
        <div>
          {projects.data.length ? <div>Projects</div> : <EmptyProjects />}
        </div>
      </div>
    </div>
  );
}
