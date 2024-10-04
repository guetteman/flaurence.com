export type RunResource = {
  data: RunResourceData;
};

export type RunResourceData = {
  id: number;
  status: string;
  output: object;
  error: string | null;
  project_id: number;
  created_at: string;
};

export type RunResourceCollection = {
  data: RunResourceData[];
};
