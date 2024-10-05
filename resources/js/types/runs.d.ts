import type { ProjectResourceData } from '@/types/projects';

export type RunResource = {
  data: RunResourceData;
};

export type RunResourceData = {
  id: number;
  status: string;
  output: { [key: string]: unknown };
  error: string | null;
  project_id: number;
  project: ProjectResourceData;
  created_at: string;
};

export type RunResourceCollection = {
  data: RunResourceData[];
};
