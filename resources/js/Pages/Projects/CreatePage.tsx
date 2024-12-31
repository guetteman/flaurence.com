import { Navbar } from '@/components/app/navbar';
import { Button } from '@/components/ui/button';
import {
  FormControl,
  FormError,
  FormField,
  FormLabel,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import { useForm } from '@inertiajs/react';
import { motion } from 'framer-motion';
import type { FormEvent } from 'react';
import { CronInput } from '@/components/ui/cron-input';
import { Textarea } from '@/components/ui/textarea';
import { Separator } from '@/components/ui/separator';
import { UrlListInput } from '@/components/ui/url-list-input';

interface FormDataType {
  name: string;
  topic: string;
  description: string;
  cron_expression: string;
  urls: string[];
}

export default function CreatePage() {
  const { slideUpInVariants } = useAnimationVariants();
  const { data, setData, errors, post, processing } = useForm<FormDataType>({
    name: '',
    topic: '',
    description: '',
    cron_expression: '0 9 1 * *',
    urls: [],
  });

  function handleSubmit(e: FormEvent<HTMLFormElement>) {
    e.preventDefault();
    post(route('projects.store'));
  }

  return (
    <AnimatedContainer className="flex min-h-screen flex-col gap-32">
      <Navbar />

      <div className="mx-auto flex w-full max-w-7xl flex-col items-center justify-center">
        <div className="space-y-4 text-center">
          <h1 className="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl">
            New Project
          </h1>
          <p className="text-xl text-muted-foreground">
            Create a new personal newsletter
          </p>
        </div>

        <motion.form
          variants={slideUpInVariants}
          className="mt-10 w-full max-w-lg space-y-1 p-4"
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
                placeholder="AI news researcher"
                required
              />
            </FormControl>
            <FormError error={errors.name} />
          </FormField>

          <FormField>
            <FormLabel htmlFor="topic">Topic</FormLabel>
            <FormControl>
              <Input
                id="topic"
                name="topic"
                value={data.topic}
                onChange={(e) => setData('topic', e.target.value)}
                placeholder="AI news researcher"
                required
              />
            </FormControl>
          </FormField>

          <FormField>
            <FormLabel htmlFor="description">Description</FormLabel>
            <FormControl>
              <Textarea
                id="description"
                name="description"
                value={data.description}
                onChange={(e) => setData('description', e.target.value)}
                placeholder="AI news researcher"
                required
              />
            </FormControl>
          </FormField>

          <FormField>
            <FormLabel>URLs</FormLabel>
            <FormControl>
              <UrlListInput
                urls={data.urls}
                onChange={(urls) => setData('urls', urls)}
              />
            </FormControl>
            <FormError error={errors.urls} />
          </FormField>

          <div>
            <Separator className="mt-6" />
          </div>

          <div className="space-y-6 border-gray-300 py-4">
            <h3 className="text-lg font-bold">Schedule</h3>
            <CronInput
              value={data.cron_expression}
              onChange={(expression) => setData('cron_expression', expression)}
            />
          </div>

          <div className="flex items-center justify-end pt-3">
            <Button type="submit" disabled={processing}>
              Create
            </Button>
          </div>
        </motion.form>
      </div>
    </AnimatedContainer>
  );
}
