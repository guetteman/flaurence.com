import {useAnimationVariants} from '@/hooks/use-animation-variants';
import { type HTMLMotionProps, motion } from 'framer-motion';

type AnimatedContainerProps = HTMLMotionProps<'div'>;

export function AnimatedContainer({
  children,
  ...props
}: AnimatedContainerProps) {
  const {fadeInVariants} = useAnimationVariants();

  return (
    <motion.div
      initial="hidden"
      animate="visible"
      variants={fadeInVariants}
      {...props}
    >
      {children}
    </motion.div>
  );
}
