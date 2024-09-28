export function useAnimationVariants() {
  const fadeInVariants = {
    hidden: { opacity: 0 },
    visible: {
      opacity: 1,
      transition: {
        when: 'beforeChildren',
        staggerChildren: 0.1,
        duration: 0.3,
      },
    },
  };

  const slideUpInVariants = {
    hidden: { y: 20, opacity: 0 },
    visible: {
      y: 0,
      opacity: 1,
      transition: { type: 'spring', stiffness: 100 },
    },
    exit: {
      y: 20,
      opacity: 0,
      transition: { duration: 0.3 },
    },
  };

  const slideDownInVariants = {
    hidden: { y: -20, height: 0, opacity: 0 },
    visible: {
      y: 0,
      opacity: 1,
      height: 'auto',
      transition: { type: 'spring', stiffness: 100 },
    },
    exit: {
      y: -20,
      opacity: 0,
      height: 0,
      transition: { duration: 0.2 },
    },
  };

  return { slideUpInVariants, slideDownInVariants, fadeInVariants };
}
