export type ProjectResource = {
  data: {
    id: number;
    name: string;
    input: unknown;
    cron_expression?: string;
    timezone?: string;
    user_id: number;
    flow_id: number;
  };
};

export type ProjectResourceCollection = {
  data: ProjectResource[];
};
