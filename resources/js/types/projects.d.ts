import type {FlowResourceData} from '@/types/flows';

export type ProjectResource = {
  data: ProjectResourceData;
};

export type ProjectResourceData = {
  id: number;
  name: string;
  input: unknown;
  cron_expression?: string;
  timezone?: string;
  user_id: number;
  flow_id: number;
  flow: FlowResourceData;
};

export type ProjectResourceCollection = {
  data: ProjectResourceData[];
};
