import { Label } from '@/components/ui/label';
import {cn} from '@/lib/utils';
import {motion} from 'framer-motion';
import {type ComponentPropsWithRef, type ReactNode, forwardRef } from 'react';

const formField = forwardRef<HTMLDivElement, ComponentPropsWithRef<'div'>>(
  ({ children, className, ...props }, ref) => {
    return (
      <div ref={ref} className={cn('space-y-1', className)} {...props}>
        {children}
      </div>
    );
  },
);

const FormField = motion(formField);

function FormLabel({
  htmlFor,
  children,
}: {
  htmlFor?: string;
  children: ReactNode;
}) {
  return (
    <Label htmlFor={htmlFor} className="px-1">
      {children}
    </Label>
  );
}

function FormControl({ children }: { children: ReactNode }) {
  return <div>{children}</div>;
}

function FormDescription({ children }: { children?: ReactNode }) {
  if (!children) {
    return null;
  }

  return <div className="px-1 text-xs text-muted-foreground">{children}</div>;
}

function FormError({ error }: { error?: string }) {
  return (
    <div className="min-h-4 px-1">
      {error && <div className="text-xs text-red-500">{error}</div>}
    </div>
  );
}

export { FormField, FormLabel, FormControl, FormDescription, FormError };
