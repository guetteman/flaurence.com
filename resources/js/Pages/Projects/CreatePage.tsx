import { Navbar } from '@/components/app/navbar';
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
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { useAnimationVariants } from '@/hooks/use-animation-variants';
import type { Flow } from '@/types/flows';
import { useForm, usePage } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { type FormEvent, useState } from 'react';

interface FormDataType {
  name: string;
  description: string;
  flow_id: string;
  input: Record<string, unknown>;
}

export default function CreatePage() {
  const { slideUpInVariants, slideDownInVariants } = useAnimationVariants();
  const [selectedFlow, setSelectedFlow] = useState<Flow | undefined>();
  const { flows } = usePage<{ flows: Flow[] }>().props;

  const { data, setData, errors, post, processing } = useForm<FormDataType>({
    name: '',
    description: '',
    flow_id: '',
    input: {},
  });

  function handleSubmit(e: FormEvent<HTMLFormElement>) {
    console.log(data.input);
    e.preventDefault();
    post(route('login'));
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
            Automate boring task effortlessly
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
              <Select
                onValueChange={(value) => {
                  setData('flow_id', value);
                  setSelectedFlow(
                    flows.find((flow) => flow.id === Number.parseInt(value)),
                  );
                }}
              >
                <SelectTrigger>
                  <SelectValue placeholder="Select a flow" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    {flows.map((flow) => (
                      <SelectItem key={flow.id} value={flow.id.toString()}>
                        <div className="text-bold">{flow.name}</div>
                        <p className="text-xs text-muted-foreground">
                          {flow.short_description}
                        </p>
                      </SelectItem>
                    ))}
                  </SelectGroup>
                </SelectContent>
              </Select>
            </FormControl>
            <FormError error={errors.name} />
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

          <FormField>
            <FormLabel htmlFor="name">Description</FormLabel>
            <FormControl>
              <Textarea
                id="description"
                name="description"
                value={data.description}
                onChange={(e) => setData('description', e.target.value)}
                placeholder="Goal of your project"
                required
              />
            </FormControl>
            <FormError error={errors.description} />
          </FormField>

          <AnimatePresence>
            {selectedFlow?.input_schema.map((item, key) => {
              if (item.type === 'text_input') {
                return (
                  <FormField
                    variants={slideDownInVariants}
                    initial="hidden"
                    animate="visible"
                    exit="exit"
                    key={item.data.id}
                  >
                    <FormLabel htmlFor={item.data.id}>
                      {item.data.name}
                    </FormLabel>
                    <FormControl>
                      <Input
                        id={item.data.id}
                        name={item.data.id}
                        type="email"
                        value={data.input[item.data.name] as string}
                        onChange={(e) =>
                          setData('input', {
                            ...data.input,
                            [item.data.id]: e.target.value,
                          })
                        }
                        placeholder="name@example.com"
                        required
                      />
                    </FormControl>
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
                    key={item.data.id}
                  >
                    <FormLabel htmlFor={item.data.id}>
                      {item.data.name}
                    </FormLabel>
                    <FormControl>
                      <Textarea
                        rows={3}
                        value={data.input[item.data.name] as string}
                        onChange={(e) =>
                          setData('input', {
                            ...data.input,
                            [item.data.id]: e.target.value
                              .replace(' ', '')
                              .split('\n'),
                          })
                        }
                        placeholder={item.data.placeholder}
                      />
                    </FormControl>
                    <FormDescription>{item.data.description}</FormDescription>
                  </FormField>
                );
              }
            })}
          </AnimatePresence>
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
