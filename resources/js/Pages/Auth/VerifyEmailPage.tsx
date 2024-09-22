import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { PageLayout } from '@/components/ui/layout/page-layout';
import { Link, router } from '@inertiajs/react';
import React from 'react';

export default function VerifyEmailPage() {
  const [processing, setProcessing] = React.useState(false);

  const handleResendVerificationEmail = () => {
    router.post(
      route('verification.send'),
      {},
      {
        onStart: () => setProcessing(true),
        onFinish: () => setProcessing(false),
      },
    );
  };

  return (
    <PageLayout title="Verify Email">
      <AnimatedContainer className="flex min-h-screen flex-col items-center justify-center p-4">
        <Card className="max-w-lg space-y-4 px-6 py-4">
          <p>
            Before continuing, could you verify your email address by clicking
            on the link we just emailed to you? If you didn't receive the email,
            we will gladly send you another.
          </p>
          <div className="flex items-center justify-between">
            <Button
              disabled={processing}
              onClick={handleResendVerificationEmail}
            >
              Resend Verification Email
            </Button>
            <Button disabled={processing} variant="link">
              <Link href={route('logout')} method="post">
                Log Out
              </Link>
            </Button>
          </div>
        </Card>
      </AnimatedContainer>
    </PageLayout>
  );
}
