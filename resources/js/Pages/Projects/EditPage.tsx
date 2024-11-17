import { Navbar } from '@/components/app/navbar';
import { FlowSelect } from '@/components/app/pages/projects/flow-select';
import { Button } from '@/components/ui/button';
import {
  FormControl,
  FormDescription,
  FormError,
  FormField,
  FormLabel,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { AnimatedContainer } from '@/components/ui/layout/animated-container';
import { Textarea } from '@/components/ui/textarea';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import type { ProjectResource } from '@/types/projects';
import { useForm } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import type { FormEvent } from 'react';
import { CronInput } from '@/components/ui/cron-input';

interface EditPageProps {
  project: ProjectResource;
}

interface FormDataType {
  name: string;
  input: Record<string, unknown>;
  cron_expression: string;
}

export default function EditPage({ project }: EditPageProps) {
  const { slideUpInVariants, slideDownInVariants } = useAnimationVariants();
  const { data, setData, errors, put, processing } = useForm<FormDataType>({
    name: project.data.name,
    input: project.data.input,
    cron_expression: project.data.cron_expression ?? '0 9 1 * *',
  });
  function handleSubmit(e: FormEvent<HTMLFormElement>) {
    put(route('projects.update', project.data.id));
    e.preventDefault();
  }

  return (
    <AnimatedContainer className="flex min-h-screen flex-col gap-32">
      <Navbar />

      <div className="mx-auto flex w-full max-w-7xl flex-col items-center justify-center">
        <div className="space-y-4 text-center">
          <h1 className="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl">
            Edit {project.data.name}
          </h1>
          <p className="text-xl text-muted-foreground">
            Update project settings
          </p>
        </div>

        <motion.form
          variants={slideUpInVariants}
          className="mt-10 w-full max-w-lg space-y-1 p-4"
          onSubmit={handleSubmit}
        >
          <FormField>
            <FormLabel>Flow</FormLabel>
            <FormControl>
              <FlowSelect value={project.data.flow_id.toString()} disabled />
            </FormControl>
          </FormField>

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

          <AnimatePresence>
            {project.data.flow.input_schema.map((item) => {
              if (item.type === 'text_input') {
                return (
                  <FormField
                    variants={slideDownInVariants}
                    initial="hidden"
                    animate="visible"
                    exit="exit"
                    key={item.key}
                  >
                    <FormLabel htmlFor={item.key}>{item.label}</FormLabel>
                    <FormControl>
                      <Input
                        id={item.key}
                        name={item.key}
                        type={item.input_type ?? 'text'}
                        value={data.input[item.key] as string}
                        onChange={(e) =>
                          setData('input', {
                            ...data.input,
                            [item.key]: e.target.value,
                          })
                        }
                        placeholder={item.placeholder}
                        required={item.required}
                      />
                    </FormControl>
                    <FormError error={errors.input} />
                  </FormField>
                );
              }

              if (item.type === 'array_input') {
                return (
                  <FormField
                    variants={slideDownInVariants}
                    initial="hidden"
                    animate="visible"
                    exit="exit"
                    key={item.key}
                  >
                    <FormLabel htmlFor={item.key}>{item.label}</FormLabel>
                    <FormControl>
                      <Textarea
                        rows={3}
                        value={(data.input[item.key] as Array<string>)?.join(
                          '\n',
                        )}
                        onChange={(e) =>
                          setData('input', {
                            ...data.input,
                            [item.key]: e.target.value
                              .replace(' ', '')
                              .split('\n'),
                          })
                        }
                        placeholder={item.placeholder}
                        required={item.required}
                      />
                    </FormControl>
                    <FormError error={errors.input} />
                    <FormDescription>{item.description}</FormDescription>
                  </FormField>
                );
              }
            })}

            <div className="space-y-6 border-t border-gray-300 py-4">
              <h3 className="text-lg font-bold">Schedule</h3>
              <CronInput
                value={data.cron_expression}
                onChange={(expression) =>
                  setData('cron_expression', expression)
                }
              />
            </div>
          </AnimatePresence>

          <div className="flex items-center justify-end pt-3">
            <Button type="submit" disabled={processing}>
              Update
            </Button>
          </div>
        </motion.form>
      </div>
    </AnimatedContainer>
  );
}
