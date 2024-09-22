import {Head} from '@inertiajs/react';
import type { ReactNode } from 'react';

type PageLayoutProps = {
  title: string;
  children: ReactNode;
};

export function PageLayout({ children, title }: PageLayoutProps) {
  return <>
    <Head title={title}/>
    {children}
  </>;
}
