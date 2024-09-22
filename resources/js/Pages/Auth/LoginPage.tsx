import { SplitLayout } from '@/components/auth/split-layout';
import { Button } from '@/components/ui/button';
import {
  FormControl,
  FormError,
  FormField,
  FormLabel,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import { Link, useForm } from '@inertiajs/react';
import { motion } from 'framer-motion';
import React, { type FormEvent } from 'react';

export default function LoginPage() {
  const { slideUpInVariants } = useAnimationVariants();
  const { data, setData, errors, post, processing } = useForm({
    email: '',
    password: '',
    remember: false,
  });

  function handleSubmit(e: FormEvent<HTMLFormElement>) {
    e.preventDefault();
    post(route('login'));
  }

  return (
    <SplitLayout>
      <div className="mx-auto w-full max-w-md space-y-8 px-4">
        <motion.div variants={slideUpInVariants} className="text-center">
          <h2 className="text-4xl font-bold">Login</h2>
          <p className="mt-2 text-sm text-gray-600">
            Enter your email below to login your account
          </p>
        </motion.div>
        <motion.form
          variants={slideUpInVariants}
          className="space-y-1"
          onSubmit={handleSubmit}
        >
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
          <Button
            type="submit"
            disabled={processing}
            className="w-full bg-black text-white hover:bg-gray-800"
          >
            Sign In
          </Button>
        </motion.form>
        <motion.div
          variants={slideUpInVariants}
          className="text-center text-sm"
        >
          Don't have an account?{' '}
          <Link href={route('register')} className="font-medium underline">
            Register here
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
  );
}
