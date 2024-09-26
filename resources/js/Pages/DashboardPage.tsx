import { Navbar } from '@/components/app/navbar';
import { FolderAddIcon } from '@/components/icons/folder-add-icon';
import { PlusSignIcon } from '@/components/icons/plus-sign-icon';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';

export default function DashboardPage() {
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
          <div className="flex h-96 flex-col justify-center text-center">
            <FolderAddIcon className="mx-auto size-12 text-gray-400" />
            <h3 className="mt-2 text-sm font-semibold text-gray-900">
              No projects
            </h3>
            <p className="mt-1 text-sm text-gray-500">
              Get started by creating a new project.
            </p>
            <div className="mt-6">
              <Button>
                <PlusSignIcon aria-hidden="true" className="mr-2 size-4" />
                New Project
              </Button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
