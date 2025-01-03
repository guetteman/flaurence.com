export type PlanResource = {
  data: PlanResourceData;
};

export type PlanResourceData = {
  id: number;
  name: string;
  type: string;
  external_product_id: string;
  external_variant_id: string;
  description: string;
  price: number;
  formatted_price: string;
  active: boolean;
  is_popular: boolean;
};

export type PlanResourceCollection = {
  data: PlanResourceData[];
};
