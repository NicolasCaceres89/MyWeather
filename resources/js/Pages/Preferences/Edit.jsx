import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Layout from '../../Components/Layout';

export default function EditPreferences() {
  const [prefs, setPrefs] = useState({ temperature_unit: '°F', time_format: '12H' });
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    let mounted = true;
    axios
      .get('/preferences/edit')
      .then((res) => {
        if (mounted && res.data) setPrefs(res.data);
      })
      .catch(() => {})
      .finally(() => setLoading(false));
    return () => (mounted = false);
  }, []);

  const save = async (e) => {
    e.preventDefault();
    setSaving(true);
    try {
      await axios.put('/preferences', {
        temperature_unit: prefs.temperature_unit,
        time_format: prefs.time_format,
      });
      alert('Preferences saved');
    } catch (err) {
      alert('Error saving preferences');
    } finally {
      setSaving(false);
    }
  };

  if (loading) return <Layout><div>Loading preferences...</div></Layout>;

  return (
    <Layout>
      <h1 className="text-2xl font-bold mb-4">Edit Preferences</h1>
      <form onSubmit={save} className="space-y-4">
        <div>
          <label className="block text-sm font-medium">Temperature Unit</label>
          <select
            value={prefs.temperature_unit}
            onChange={(e) => setPrefs({ ...prefs, temperature_unit: e.target.value })}
            className="mt-1 block w-full border rounded p-2"
          >
            <option>°F</option>
            <option>°C</option>
            <option>°K</option>
          </select>
        </div>

        <div>
          <label className="block text-sm font-medium">Time Format</label>
          <select
            value={prefs.time_format}
            onChange={(e) => setPrefs({ ...prefs, time_format: e.target.value })}
            className="mt-1 block w-full border rounded p-2"
          >
            <option value="12H">12H</option>
            <option value="24H">24H</option>
          </select>
        </div>

        <div>
          <button type="submit" disabled={saving} className="px-4 py-2 bg-blue-600 text-white rounded">
            {saving ? 'Saving...' : 'Save Preferences'}
          </button>
        </div>
      </form>
    </Layout>
  );
}
