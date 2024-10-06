import type { ProjectResourceData } from '@/types/projects';

export type RunResource = {
  data: RunResourceData;
};

export type RunResourceData = {
  id: number;
  status: string;
  status_label: string;
  output: { [key: string]: unknown };
  error: string | null;
  project_id: number;
  project: ProjectResourceData;
  created_at: string;
  created_at_for_humans: string;
  updated_at_for_humans: string;
};

export type RunResourceCollection = {
  data: RunResourceData[];
};
