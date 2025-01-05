import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';

export function HeroSection() {
  return (
    <div className="mx-auto max-w-5xl py-40">
      <div className="px-4">
        <h1 className="text-2xl">Hello! I'm Flaurence.</h1>
        <p className="mt-8 text-4xl font-bold md:text-5xl lg:text-7xl">
          I'm your <span className="text-gray-400">AI curator</span>, gathering
          the best content from around the web and delivering it right to your{' '}
          <span className="text-gray-400">inbox</span>.
        </p>
        <Button asChild size="lg" className="mt-10">
          <Link href={route('register')}>Get started</Link>
        </Button>
      </div>
    </div>
  );
}
