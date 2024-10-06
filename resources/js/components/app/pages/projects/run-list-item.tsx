import { RunStatusIcon } from '@/components/app/pages/projects/run-status-icon';
import type { RunResourceData } from '@/types/runs';
import { Link } from '@inertiajs/react';

function Content({ run }: { run: RunResourceData }) {
  return (
    <div className="flex space-x-2">
      <RunStatusIcon status={run.status} />
      <div className="text-sm font-medium text-gray-900">
        {run.status_label}
        <div className="text-sm text-gray-500">{run.updated_at_for_humans}</div>
      </div>
    </div>
  );
}

export function RunListItem({ run }: { run: RunResourceData }) {
  if (run.status === 'completed') {
    return (
      <Link
        href={route('runs.show', {
          project: run.project_id,
          run: run.id,
        })}
        className="block rounded-2xl p-4 hover:bg-gray-50"
      >
        <Content run={run} />
      </Link>
    );
  }

  return (
    <div className="block rounded-2xl p-4 hover:bg-gray-50">
      <Content run={run} />
    </div>
  );
}
