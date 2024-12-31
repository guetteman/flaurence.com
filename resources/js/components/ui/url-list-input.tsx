import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Cancel01Icon } from '@/components/icons/cancel-01-icon';
import { motion, AnimatePresence } from 'framer-motion';

interface UrlListInputProps {
  urls: string[];
  onChange: (urls: string[]) => void;
}

export function UrlListInput({ urls, onChange }: UrlListInputProps) {
  const handleUrlChange = (index: number, value: string) => {
    const newUrls = [...urls];
    newUrls[index] = value;
    onChange(newUrls);
  };

  const addUrl = () => {
    onChange([...urls, '']);
  };

  const removeUrl = (index: number) => {
    const newUrls = urls.filter((_, i) => i !== index);
    onChange(newUrls);
  };

  return (
    <div className="space-y-2">
      <AnimatePresence initial={false}>
        {urls.map((url, index) => (
          <motion.div
            // biome-ignore lint/suspicious/noArrayIndexKey: Url can be the empty string
            key={`url-${index}`}
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: 'auto' }}
            exit={{ opacity: 0, height: 0 }}
            transition={{ duration: 0.2 }}
            className="flex gap-2"
          >
            <Input
              value={url}
              onChange={(e) => handleUrlChange(index, e.target.value)}
              placeholder="https://example.com"
              type="url"
            />
            <Button
              type="button"
              variant="ghost"
              size="icon"
              onClick={() => removeUrl(index)}
              title="Remove URL"
            >
              <Cancel01Icon className="size-5 text-red-500" />
              <span className="sr-only">Remove URL</span>
            </Button>
          </motion.div>
        ))}
      </AnimatePresence>
      <Button
        type="button"
        variant="outline"
        className="w-full"
        onClick={addUrl}
      >
        Add URL
      </Button>
    </div>
  );
}
