import type { SVGProps } from 'react';

export function IsotypeDark(props: SVGProps<SVGSVGElement>) {
  return (
    <svg
      viewBox="0 0 1024 1024"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
      {...props}
    >
      <title>Flaurence isotype</title>
      <rect width="1024" height="1024" rx="200" fill="white" />
      <path d="M567 932V92H722V932H567Z" fill="black" />
      <path
        d="M237.927 293.37C237.927 172.548 316.105 92 436.822 92H501.204V224.329H460.965C414.978 224.329 393.134 248.493 393.134 295.671V333.644H515V465.973H393.134V932H237.927V465.973H154V333.644H237.927V293.37Z"
        fill="black"
      />
      <circle cx="822" cy="884" r="48" fill="black" />
    </svg>
  );
}
