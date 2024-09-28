import { SplitLayout } from '@/components/auth/split-layout';
import { Button } from '@/components/ui/button';
import {
  FormControl,
  FormError,
  FormField,
  FormLabel,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { PageLayout } from '@/components/ui/layout/page-layout';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import { Link, useForm } from '@inertiajs/react';
import { motion } from 'framer-motion';
import type { FormEvent } from 'react';

export default function RegisterPage() {
  const { slideUpInVariants } = useAnimationVariants();
  const { data, setData, errors, post, processing } = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    remember: false,
  });

  function handleSubmit(e: FormEvent<HTMLFormElement>) {
    e.preventDefault();
    post(route('register'));
  }

  return (
    <PageLayout title="Register">
      <SplitLayout>
        <div className="mx-auto w-full max-w-md space-y-8 px-4">
          <motion.div variants={slideUpInVariants} className="text-center">
            <h2 className="text-3xl font-bold">Create new account</h2>
            <p className="mt-2 text-sm text-gray-600">
              Enter your email below to create your account
            </p>
          </motion.div>
          <motion.form
            variants={slideUpInVariants}
            className="space-y-1"
            onSubmit={handleSubmit}
          >
            <FormField>
              <FormLabel htmlFor="name">Name</FormLabel>
              <FormControl>
                <Input
                  id="name"
                  name="name"
                  value={data.name}
                  onChange={(e) => setData('name', e.target.value)}
                  placeholder="John Doe"
                  required
                />
              </FormControl>
              <FormError error={errors.name} />
            </FormField>
            <FormField>
              <FormLabel htmlFor="email">Email Address</FormLabel>
              <FormControl>
                <Input
                  id="email"
                  name="email"
                  type="email"
                  value={data.email}
                  onChange={(e) => setData('email', e.target.value)}
                  placeholder="name@example.com"
                  required
                />
              </FormControl>
              <FormError error={errors.email} />
            </FormField>
            <FormField>
              <FormLabel htmlFor="password">Password</FormLabel>
              <FormControl>
                <Input
                  id="password"
                  name="password"
                  type="password"
                  placeholder="Enter your password"
                  value={data.password}
                  onChange={(e) => setData('password', e.target.value)}
                  required
                />
              </FormControl>
              <FormError error={errors.password} />
            </FormField>
            <FormField>
              <FormLabel htmlFor="password_confirmation">
                Confirm Password
              </FormLabel>
              <FormControl>
                <Input
                  id="password_confirmation"
                  name="password_confirmation"
                  type="password"
                  placeholder="Confirm your password"
                  value={data.password_confirmation}
                  onChange={(e) =>
                    setData('password_confirmation', e.target.value)
                  }
                  required
                />
              </FormControl>
              <FormError error={errors.password_confirmation} />
            </FormField>
            <Button type="submit" disabled={processing} className="w-full">
              Create Account
            </Button>
          </motion.form>
          <motion.div
            variants={slideUpInVariants}
            className="text-center text-sm"
          >
            Do you have an account already?{' '}
            <Link href={route('login')} className="font-medium underline">
              Sign In
            </Link>
          </motion.div>
          {/*<p className="text-center text-sm text-gray-600">*/}
          {/*  By clicking continue, you agree to our{' '}*/}
          {/*  <Link href="#" className="underline">*/}
          {/*    Terms of Service*/}
          {/*  </Link>{' '}*/}
          {/*  and{' '}*/}
          {/*  <Link href="#" className="underline">*/}
          {/*    Privacy Policy*/}
          {/*  </Link>*/}
          {/*  .*/}
          {/*</p>*/}
        </div>
      </SplitLayout>
    </PageLayout>
  );
}
