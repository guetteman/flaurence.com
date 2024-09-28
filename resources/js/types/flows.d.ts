export type FlowResourceCollection = {
  data: FlowResourceData[];
};

export type FlowResource = {
  data: FlowResourceData;
};

export type FlowResourceData = {
  id: number;
  name: string;
  short_description: string;
  description: string;
  version: string;
  input_schema: InputSchema[];
};

type InputSchema = {
  type: 'text_input' | 'array_input';
  data: {
    id: string;
    name: string;
    placeholder?: string;
    description?: string;
    type?: string;
    [key: string]: unknown;
  };
};
