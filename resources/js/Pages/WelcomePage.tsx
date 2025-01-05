import { Navbar } from '@/components/app/navbar';
import { FeaturedSentences } from '@/components/app/pages/welcome/featured-sentences';
import { HeroSection } from '@/components/app/pages/welcome/hero-section';
import { PricingSection } from '@/components/app/pages/welcome/pricing-section';

export default function WelcomePage() {
  return (
    <div>
      <Navbar />
      <HeroSection />
      <FeaturedSentences />
      <PricingSection />
    </div>
  );
}
