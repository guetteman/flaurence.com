import { Cancel01Icon } from '@/components/icons/cancel-02-icon';
import { Rocket01Icon } from '@/components/icons/rocket-01-icon';
import { Tick02Icon } from '@/components/icons/tick-02-icon';
import { Timer01Icon } from '@/components/icons/timer-01-icon';

export function RunStatusIcon({ status }: { status: string }) {
  switch (status) {
    case 'queued':
      return (
        <div className="borde flex size-6 items-center justify-center rounded-full border-gray-200 bg-gray-50">
          <Rocket01Icon className="size-4 text-gray-600" />
        </div>
      );
    case 'running':
      return (
        <div className="flex size-6 items-center justify-center rounded-full border border-blue-200 bg-blue-50">
          <Timer01Icon className="size-4 text-blue-500" />
        </div>
      );
    case 'completed':
      return (
        <div className="flex size-6 items-center justify-center rounded-full border border-green-200 bg-green-50">
          <Tick02Icon className="size-4 text-green-500" />
        </div>
      );
    case 'failed':
      return (
        <div className="flex size-6 items-center justify-center rounded-full border border-red-200 bg-red-50">
          <Cancel01Icon className="size-4 text-red-500" />
        </div>
      );
    default:
      return null;
  }
}
