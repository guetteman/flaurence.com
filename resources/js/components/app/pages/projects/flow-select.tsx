import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import type { FlowResourceCollection } from '@/types/flows';
import { usePage } from '@inertiajs/react';

interface FlowSelectProps {
  value?: string;
  onValueChange?: (value: string) => void;
  disabled?: boolean;
}

export function FlowSelect({
  value,
  onValueChange,
  disabled,
}: FlowSelectProps) {
  const { flows } = usePage<{ flows: FlowResourceCollection }>().props;

  return (
    <Select value={value} onValueChange={onValueChange} disabled={disabled}>
      <SelectTrigger>
        <SelectValue placeholder="Select a flow" />
      </SelectTrigger>
      <SelectContent>
        <SelectGroup>
          {flows.data.map((flow) => (
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
  );
}
