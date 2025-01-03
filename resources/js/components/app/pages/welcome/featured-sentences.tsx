import { motion, AnimatePresence } from 'framer-motion';
import { useState, useEffect } from 'react';
import type { ReactNode } from 'react';

const sentences: ReactNode[] = [
  <div key={2} className="font-extralight">
    Experience the future of{' '}
    <span className="text-primary-600 font-semibold">newsletters</span>.
  </div>,
  <div key={0} className="font-extralight">
    Simply{' '}
    <span className="text-primary-600 font-semibold">
      add your favorite links
    </span>{' '}
    and let me do the rest.
  </div>,
  <div key={1} className="font-extralight">
    Get started today and{' '}
    <span className="text-primary-600 font-semibold">free up your time</span>.
  </div>,
];

export function FeaturedSentences() {
  const [currentIndex, setCurrentIndex] = useState(0);

  useEffect(() => {
    const timer = setInterval(() => {
      setCurrentIndex((prev) => (prev + 1) % sentences.length);
    }, 3000);

    return () => clearInterval(timer);
  }, []);

  return (
    <div className="relative flex h-20 items-center justify-center">
      <AnimatePresence mode="wait">
        <motion.div
          key={currentIndex}
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          exit={{ opacity: 0, y: -20 }}
          transition={{ duration: 0.5 }}
          className="absolute text-center text-3xl text-gray-800"
        >
          {sentences[currentIndex]}
        </motion.div>
      </AnimatePresence>
    </div>
  );
}
