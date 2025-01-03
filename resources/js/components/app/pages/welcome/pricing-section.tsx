import { useEffect, useState } from 'react';
import { Radio, RadioGroup } from '@headlessui/react';
import { cn } from '@/lib/utils';
import type { PlanResourceCollection, PlanResourceData } from '@/types/plans';
import { usePage } from '@inertiajs/react';

type Frequency = {
  value: 'monthly' | 'yearly';
  label: string;
  priceSuffix: string;
};

const frequencies: Frequency[] = [
  { value: 'monthly', label: 'Monthly', priceSuffix: '/month' },
  { value: 'yearly', label: 'Annually', priceSuffix: '/year' },
];

export function PricingSection() {
  const { activePlans } = usePage<{ activePlans: PlanResourceCollection }>()
    .props;
  const [frequency, setFrequency] = useState<Frequency>(frequencies[0]);
  const [plans, setPlans] = useState<PlanResourceData[]>(
    activePlans.data.filter((plan) => plan.type === frequency.value),
  );

  useEffect(() => {
    setPlans(activePlans.data.filter((plan) => plan.type === frequency.value));
  }, [activePlans, frequency]);

  return (
    <div className="bg-white py-24 sm:py-40">
      <div className="mx-auto max-w-7xl px-6 lg:px-8">
        <div className="mx-auto max-w-4xl text-center">
          <h2 className="text-base/7 font-semibold text-gray-600">Pricing</h2>
          <p className="mt-2 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-6xl">
            Pricing that grows with you
          </p>
        </div>
        <p className="mx-auto mt-6 max-w-2xl text-pretty text-center text-lg font-medium text-gray-600 sm:text-xl/8">
          Choose an affordable plan that’s packed with the best features for
          engaging your audience, creating customer loyalty, and driving sales.
        </p>
        <div className="mt-16 flex justify-center">
          <fieldset aria-label="Payment frequency">
            <RadioGroup
              value={frequency}
              onChange={setFrequency}
              className="grid grid-cols-2 gap-x-1 rounded-full p-1 text-center text-xs/5 font-semibold ring-1 ring-inset ring-gray-200"
            >
              {frequencies.map((option) => (
                <Radio
                  key={option.value}
                  value={option}
                  className="cursor-pointer rounded-full px-2.5 py-1 text-gray-500 data-[checked]:bg-gray-900 data-[checked]:text-white"
                >
                  {option.label}
                </Radio>
              ))}
            </RadioGroup>
          </fieldset>
        </div>
        <div className="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 md:max-w-2xl md:grid-cols-2 lg:max-w-4xl">
          {plans.map((plan) => (
            <div
              key={plan.id}
              className={cn(
                plan.is_popular
                  ? 'ring-2 ring-gray-600'
                  : 'ring-1 ring-gray-200',
                'rounded-3xl p-8 xl:p-10',
              )}
            >
              <div className="flex items-center justify-between gap-x-4">
                <h3
                  id={`tier-${plan.id}`}
                  className={cn(
                    plan.is_popular ? 'text-gray-600' : 'text-gray-900',
                    'text-lg/8 font-semibold',
                  )}
                >
                  {plan.name}
                </h3>
                {plan.is_popular ? (
                  <p className="rounded-full bg-gray-600/10 px-2.5 py-1 text-xs/5 font-semibold text-gray-600">
                    Most popular
                  </p>
                ) : null}
              </div>
              <p className="mt-4 text-sm/6 text-gray-600">{plan.description}</p>
              <p className="mt-6 flex items-baseline gap-x-1">
                <span className="text-4xl font-semibold tracking-tight text-gray-900">
                  {plan.formatted_price}
                </span>
                <span className="text-sm/6 font-semibold text-gray-600">
                  {frequency.priceSuffix}
                </span>
              </p>
              <a
                href={`/register?plan=${plan.id}`}
                aria-describedby={`tier-${plan.id}`}
                className={cn(
                  plan.is_popular
                    ? 'bg-gray-900 text-white shadow-sm hover:bg-gray-800'
                    : 'text-gray-600 ring-1 ring-inset ring-gray-200 hover:ring-gray-300',
                  'mt-6 block rounded-md px-3 py-2 text-center text-sm/6 font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600',
                )}
              >
                Buy plan
              </a>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
