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
  key: string;
  label: string;
  input_type?: string;
  placeholder?: string;
  description?: string;
  required?: boolean;
  minLength?: number;
};
