import type { ProjectCreatePageProps } from '@/Pages/Projects/CreatePage';
import { Button } from '@/components/ui/button';
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card';
import type { Flow } from '@/types/flows';
import { usePage } from '@inertiajs/react';

interface SelectFlowFormStepProps {
  onSelect: (flow: Flow) => void;
}

export function SelectFlowFormStep({ onSelect }: SelectFlowFormStepProps) {
  const { flows } = usePage<ProjectCreatePageProps>().props;

  return (
    <div className="grid w-full grid-cols-1 gap-4 lg:grid-cols-3">
      {flows.map((flow) => (
        <Card key={flow.id}>
          <CardHeader className="min-h-20">
            <CardTitle>{flow.name}</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="min-h-20">
              <p className="line-clamp-3">{flow.short_description}</p>
            </div>
          </CardContent>
          <CardFooter className="flex items-center justify-end">
            <Button onClick={() => onSelect(flow)}>Select Flow</Button>
          </CardFooter>
        </Card>
      ))}
    </div>
  );
}
