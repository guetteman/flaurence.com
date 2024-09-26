import { Label } from '@/components/ui/label';
import type { ReactNode } from 'react';

function FormField({ children }: { children: ReactNode }) {
  return <div className="space-y-1">{children}</div>;
}

function FormLabel({
  htmlFor,
  children,
}: {
  htmlFor: string;
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

function FormError({ error }: { error?: string }) {
  return (
    <div className="min-h-4 px-1">
      {error && <div className="text-xs text-red-500">{error}</div>}
    </div>
  );
}

export { FormField, FormLabel, FormControl, FormError };
