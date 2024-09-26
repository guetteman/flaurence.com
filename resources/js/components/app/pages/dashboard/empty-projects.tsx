import { FolderAddIcon } from '@/components/icons/folder-add-icon';
import { PlusSignIcon } from '@/components/icons/plus-sign-icon';
import { Button } from '@/components/ui/button';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import { motion } from 'framer-motion';

export function EmptyProjects() {
  const { slideUpInVariants } = useAnimationVariants();
  return (
    <motion.div
      variants={slideUpInVariants}
      className="flex h-96 flex-col justify-center text-center"
    >
      <FolderAddIcon className="mx-auto size-12 text-gray-400" />
      <h3 className="mt-2 text-sm font-semibold text-gray-900">No projects</h3>
      <p className="mt-1 text-sm text-gray-500">
        Get started by creating a new project.
      </p>
      <motion.div variants={slideUpInVariants} className="mt-6">
        <Button>
          <PlusSignIcon aria-hidden="true" className="mr-2 size-4" />
          New Project
        </Button>
      </motion.div>
    </motion.div>
  );
}
