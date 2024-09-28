export type Flow = {
  id: number;
  name: string;
  short_description: string;
  description: string;
  input_schema: InputSchema[];
  timezone?: string;
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
