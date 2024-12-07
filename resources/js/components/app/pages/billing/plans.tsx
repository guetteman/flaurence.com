import { useMemo, useState } from 'react';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import type { PlanResourceCollection } from '@/types/plans';
import { motion } from 'framer-motion';
import { useAnimationVariants } from '@/hooks/use-animation-variants';

const frequencies = [
  { value: 'monthly', label: 'Monthly', priceSuffix: '/month' },
  { value: 'yearly', label: 'Annually', priceSuffix: '/year' },
];

interface PlansProps {
  plans: PlanResourceCollection;
}

export function Plans({ plans }: PlansProps) {
  const [frequency, setFrequency] = useState(frequencies[0]);
  const { slideUpInVariants } = useAnimationVariants();

  const tiers = useMemo(() => {
    return plans.data.filter((plan) => plan.type === frequency.value);
  }, [plans, frequency]);

  return (
    <motion.div variants={slideUpInVariants}>
      <div className="mx-auto max-w-7xl px-6 lg:px-8">
        <div className="mx-auto mt-16 max-w-4xl text-center">
          <h2 className="text-4xl font-semibold">
            Select a plan that works for you
          </h2>
        </div>
        <div className="mt-16 flex justify-center">
          <fieldset aria-label="Payment frequency">
            <div className="grid grid-cols-2 gap-x-1 rounded-full p-1 text-center text-xs/5 font-semibold ring-1 ring-inset ring-gray-200">
              {frequencies.map((option) => (
                <Button
                  key={option.value}
                  variant="ghost"
                  className="cursor-pointer rounded-full px-2.5 py-1 text-gray-500 data-[checked]:bg-black data-[checked]:text-white"
                  onClick={() => setFrequency(option)}
                  {...(option.value === frequency.value
                    ? { 'data-checked': true }
                    : {})}
                >
                  {option.label}
                </Button>
              ))}
            </div>
          </fieldset>
        </div>
        <div className="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 lg:max-w-4xl lg:grid-cols-2">
          {tiers.map((plan, index) => (
            <div
              key={plan.id}
              className={cn(
                index === 1 ? 'ring-2 ring-black' : 'ring-1 ring-gray-200',
                'rounded-3xl p-8 xl:p-10',
              )}
            >
              <div className="flex items-center justify-between gap-x-4">
                <h3
                  id={String(plan.id)}
                  className={cn(
                    index === 1 ? 'text-black' : 'text-gray-900',
                    'text-lg/8 font-semibold',
                  )}
                >
                  {plan.name}
                </h3>
                {index === 1 ? (
                  <p className="rounded-full bg-black/10 px-2.5 py-1 text-xs/5 font-semibold text-black">
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
                href={route('billing.subscribe', plan.external_variant_id)}
                className={cn(
                  index === 1
                    ? 'bg-black text-white shadow-sm hover:bg-gray-800'
                    : 'text-black ring-1 ring-inset ring-gray-200 hover:ring-gray-300',
                  'mt-6 block rounded-md px-3 py-2 text-center text-sm/6 font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black',
                )}
              >
                Select plan
              </a>
            </div>
          ))}
        </div>
      </div>
    </motion.div>
  );
}
