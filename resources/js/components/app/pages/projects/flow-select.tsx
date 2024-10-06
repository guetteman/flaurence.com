import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import type { FlowResourceCollection } from '@/types/flows';
import { usePage } from '@inertiajs/react';
import { ItemText } from '@radix-ui/react-select';

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
        {flows.data.map((flow) => (
          <SelectItem key={flow.id} value={flow.id.toString()}>
            <ItemText key={flow.id} className="text-bold block">
              {flow.name}
            </ItemText>
            <p className="text-xs text-muted-foreground">
              {flow.short_description}
            </p>
          </SelectItem>
        ))}
      </SelectContent>
    </Select>
  );
}
