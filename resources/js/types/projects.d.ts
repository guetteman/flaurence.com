export type ProjectResource = {
  data: ProjectResourceData;
};

export type ProjectResourceData = {
  id: number;
  name: string;
  topic: string;
  description: string;
  urls: string[];
  cron_expression?: string;
  timezone?: string;
  user_id: number;
};

export type ProjectResourceCollection = {
  data: ProjectResourceData[];
};
