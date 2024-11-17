import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { useCallback, useEffect, useState } from 'react';
import { ItemText } from '@radix-ui/react-select';

interface CronScheduleBuilderProps {
  value: string;
  onChange: (expression: string) => void;
}

export function CronInput({ value, onChange }: CronScheduleBuilderProps) {
  const [frequency, setFrequency] = useState('day');
  const [dayOfWeek, setDayOfWeek] = useState('1');
  const [dayOfMonth, setDayOfMonth] = useState('1');
  const [time, setTime] = useState('00:00');
  const [minute, setMinute] = useState('0');
  const [init, setInit] = useState(false);

  const frequencies = [
    { value: 'day', label: 'Day' },
    { value: 'week', label: 'Week' },
    { value: 'month', label: 'Month' },
  ];

  const daysOfWeek = [
    { value: '0', label: 'Sunday' },
    { value: '1', label: 'Monday' },
    { value: '2', label: 'Tuesday' },
    { value: '3', label: 'Wednesday' },
    { value: '4', label: 'Thursday' },
    { value: '5', label: 'Friday' },
    { value: '6', label: 'Saturday' },
  ];

  const daysOfMonth = Array.from({ length: 31 }, (_, i) => {
    const day = i + 1;
    const suffix =
      ['st', 'nd', 'rd'][((((day + 90) % 100) - 10) % 10) - 1] || 'th';
    return { value: String(day), label: `${day}${suffix}` };
  });

  const minutes = Array.from({ length: 60 }, (_, i) => ({
    value: String(i),
    label: String(i).padStart(2, '0'),
  }));

  const generateCronExpression = useCallback(() => {
    let expression = '';
    const [hours, minutes] = time.split(':').map(Number);

    switch (frequency) {
      case 'minute':
        expression = '* * * * *';
        break;
      case 'hour':
        expression = `${minute} * * * *`;
        break;
      case 'day':
        expression = `${minutes} ${hours} * * *`;
        break;
      case 'week':
        expression = `${minutes} ${hours} * * ${dayOfWeek}`;
        break;
      case 'month':
        expression = `${minutes} ${hours} ${dayOfMonth} * *`;
        break;
    }
    return expression;
  }, [frequency, dayOfWeek, dayOfMonth, time, minute]);

  // biome-ignore lint/correctness/useExhaustiveDependencies: <explanation>
  useEffect(() => {
    const newExpression = generateCronExpression();
    if (value !== newExpression && init) {
      onChange(newExpression);
    }
  }, [generateCronExpression]);

  // biome-ignore lint/correctness/useExhaustiveDependencies: <explanation>
  useEffect(() => {
    if (value !== generateCronExpression()) {
      const [newMinute, newHour, newDay, newMonth, newDayOfWeek] =
        value.split(' ');
      setMinute(newMinute);
      setTime(`${newHour.padStart(2, '0')}:${newMinute.padStart(2, '0')}`);
      setDayOfMonth(newDay);
      setDayOfWeek(newDayOfWeek);
      setFrequency(
        newDayOfWeek !== '*' ? 'week' : newDay !== '*' ? 'month' : 'day',
      );
      setInit(true);
    }
  }, [value]);

  return (
    <div className="space-y-6">
      <div className="grid gap-2">
        <Label htmlFor="frequency">Frequency</Label>
        <Select value={frequency} onValueChange={setFrequency}>
          <SelectTrigger id="frequency" className="w-full">
            <SelectValue placeholder="Select a frequency" />
          </SelectTrigger>
          <SelectContent>
            {frequencies.map((freq) => (
              <SelectItem key={freq.value} value={freq.value}>
                <ItemText className="text-bold block">{freq.label}</ItemText>
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
      </div>

      {frequency === 'week' && (
        <div className="grid gap-2">
          <Label htmlFor="dayOfWeek">Day of Week</Label>
          <Select value={dayOfWeek} onValueChange={setDayOfWeek}>
            <SelectTrigger id="dayOfWeek" className="w-full">
              <SelectValue placeholder="Select day" />
            </SelectTrigger>
            <SelectContent>
              {daysOfWeek.map((day) => (
                <SelectItem key={day.value} value={day.value}>
                  <ItemText className="text-bold block">{day.label}</ItemText>
                </SelectItem>
              ))}
            </SelectContent>
          </Select>
        </div>
      )}

      {frequency === 'month' && (
        <div className="grid gap-2">
          <Label htmlFor="dayOfMonth">Day of Month</Label>
          <Select value={dayOfMonth} onValueChange={setDayOfMonth}>
            <SelectTrigger id="dayOfMonth" className="w-full">
              <SelectValue placeholder="Select day" />
            </SelectTrigger>
            <SelectContent>
              {daysOfMonth.map((day) => (
                <SelectItem key={day.value} value={day.value}>
                  <ItemText className="text-bold block">{day.label}</ItemText>
                </SelectItem>
              ))}
            </SelectContent>
          </Select>
        </div>
      )}

      {frequency === 'hour' && (
        <div className="grid gap-2">
          <Label htmlFor="minute">Minute</Label>
          <Select value={minute} onValueChange={setMinute}>
            <SelectTrigger id="minute" className="w-full">
              <SelectValue placeholder="Select minute" />
            </SelectTrigger>
            <SelectContent>
              {minutes.map((min) => (
                <SelectItem key={min.value} value={min.value}>
                  <ItemText className="text-bold block">{min.label}</ItemText>
                </SelectItem>
              ))}
            </SelectContent>
          </Select>
        </div>
      )}

      {(frequency === 'day' ||
        frequency === 'week' ||
        frequency === 'month') && (
        <div className="grid gap-2">
          <Label htmlFor="time">Time</Label>
          <Input
            type="time"
            id="time"
            value={time}
            onChange={(e) => setTime(e.target.value)}
            className="w-full"
          />
        </div>
      )}
    </div>
  );
}
