import { FeaturedSentences } from '@/components/app/pages/welcome/featured-sentences';
import { HeroSection } from '@/components/app/pages/welcome/hero-section';

export default function WelcomePage() {
  return (
    <div>
      <HeroSection />
      <FeaturedSentences />
    </div>
  );
}
