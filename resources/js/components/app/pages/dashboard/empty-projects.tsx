import { FolderAddIcon } from '@/components/icons/folder-add-icon';
import { PlusSignIcon } from '@/components/icons/plus-sign-icon';
import { Button } from '@/components/ui/button';

export function EmptyProjects() {
  return (
    <div className="flex h-96 flex-col justify-center text-center">
      <FolderAddIcon className="mx-auto size-12 text-gray-400" />
      <h3 className="mt-2 text-sm font-semibold text-gray-900">No projects</h3>
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
  );
}
