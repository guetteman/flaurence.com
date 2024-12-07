import { usePage } from '@inertiajs/react';
import type { SubscriptionResource } from '@/types/subscriptions';
import type { PlanResource } from '@/types/plans';
import { format, parseJSON } from 'date-fns';
import { Separator } from '@/components/ui/separator';

export function ActiveSubscription() {
  const { activeSubscription, activePlan } = usePage<{
    activeSubscription: SubscriptionResource;
    activePlan: PlanResource;
  }>().props;

  return (
    <div className="space-y-4">
      <h2 className="text-xl font-bold">Active Subscription</h2>

      <div className="grid grid-cols-1 gap-4 rounded-3xl border border-black bg-white p-4 shadow-sm lg:grid-cols-2">
        <div>
          <h2 className="text-2xl font-bold">{activePlan.data.name}</h2>
          <div
            className="prose-sm"
            dangerouslySetInnerHTML={{ __html: activePlan.data.description }}
          />
        </div>
        <div className="space-y-2">
          <div className="flex items-center justify-between">
            <h2 className="text-gray-500">Subscription Status</h2>
            <p>{activeSubscription.data.status}</p>
          </div>
          <Separator />
          <div className="flex items-center justify-between">
            <h2 className="text-gray-500">Price</h2>
            <p>{activePlan.data.formatted_price}$</p>
          </div>
          <Separator />
          <div className="flex items-center justify-between">
            <h2 className="text-gray-500">Renews At</h2>
            <p>
              {format(
                parseJSON(activeSubscription.data.renews_at),
                'EEE, d LLL. yyyy',
              )}
            </p>
          </div>
          <Separator />
          <div className="flex items-center justify-between">
            <h2 className="text-gray-500">Variant ID</h2>
            <p>{activeSubscription.data.variant_id}</p>
          </div>
          <Separator />
          <div className="flex items-center justify-between">
            <h2 className="text-gray-500">Card</h2>
            <p>
              {activeSubscription.data.card_brand} -{' '}
              {activeSubscription.data.card_last_four}
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}
