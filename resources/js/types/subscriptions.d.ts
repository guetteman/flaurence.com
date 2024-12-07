export type SubscriptionResource = {
  data: SubscriptionResourceData;
};

export type SubscriptionResourceData = {
  id: number;
  status: string;
  variant_id: string;
  card_brand: string;
  card_last_four: string;
  pause_mode: string;
  pause_resumes_at: string;
  trial_ends_at: string;
  renews_at: string;
  ends_at: string;
  created_at: string;
};
