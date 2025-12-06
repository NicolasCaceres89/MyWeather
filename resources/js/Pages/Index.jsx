import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Layout from '../Components/Layout';

export default function Index() {
  return (
    <Layout>
      <h1 className="text-2xl font-bold mb-4">Welcome to MyWeather</h1>
      <p className="text-gray-700">This is the user-facing home page. We'll build user views and the external API connection here.</p>
    </Layout>
  );
}
