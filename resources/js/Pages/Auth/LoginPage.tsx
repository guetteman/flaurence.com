import { Button } from '@/components/ui/button';
import {
  FormControl,
  FormError,
  FormField,
  FormLabel,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Link, useForm } from '@inertiajs/react';
import { Scissors } from 'lucide-react';
import React, { type FormEvent } from 'react';

export default function LoginPage() {
  const { data, setData, errors, post, processing } = useForm({
    email: '',
    password: '',
    remember: false,
  });

  function handleSubmit(e: FormEvent<HTMLFormElement>) {
    e.preventDefault();
    post('/login');
  }

  return (
    <div className="flex min-h-screen">
      <div className="hidden w-1/2 bg-black text-white lg:block">
        <div className="flex h-full flex-col justify-between p-8">
          <div className="flex items-center space-x-2">
            <Scissors className="size-8" />
            <span className="text-xl font-bold">Flaurence</span>
          </div>
          <div className="max-w-2xl">
            <blockquote>
              "This library has saved me countless hours of work and helped me
              deliver stunning designs to my clients faster than ever before."
            </blockquote>
            <cite className="mt-2 block">Sofia Davis</cite>
          </div>
        </div>
      </div>
      <div className="flex w-full items-center justify-center lg:w-1/2">
        <div className="mx-auto w-full max-w-md space-y-8 px-4">
          <div className="text-center">
            <h2 className="text-4xl font-bold">Login</h2>
            <p className="mt-2 text-sm text-gray-600">
              Enter your email below to login your account
            </p>
          </div>
          <form className="space-y-1" onSubmit={handleSubmit}>
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
          </form>
          <div className="text-center text-sm">
            Don't have an account?{' '}
            <Link href={route('register')} className="font-medium underline">
              Register here
            </Link>
          </div>
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
      </div>
    </div>
  );
}
